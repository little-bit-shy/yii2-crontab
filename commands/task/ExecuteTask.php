<?php
namespace app\commands\task;

use Swoole\Coroutine;
use Yii;
use yii\db\Query;
use swoole_async;

/**
 * 获取需要执行任务数据
 * Class ExecuteTask
 * @package app\commands\task
 */
class ExecuteTask
{
    private static $select = [
        'command',
        'start_time',
    ];
    private static $table = 'yii2_execute_task';
    private static $where = [
        'status' => 1
    ];

    /**
     * 获取任务源数据
     * @return array
     */
    public static function get()
    {
        $tasks = (new Query())->from(self::$table)
            ->select(self::$select)
            ->where(self::$where)
            ->all();
        return $tasks;
    }

    /**
     * 添加需要执行任务数据
     * @return array
     */
    public static function set($rows)
    {
        return Yii::$app->db->createCommand()->insert(self::$table, $rows)->execute();
    }

    /**
     * 获取最后插入的id
     * @return mixed
     */
    public static function getInsertId()
    {
        $data = Yii::$app->db->createCommand('SELECT LAST_INSERT_ID() last_insert_id')->queryOne();
        return $data['last_insert_id'];
    }

    /**
     * 修改任务状态
     * @param $id
     * @param $status
     * @param null $execute_time
     * @param null $result
     * @param null $complete_time
     * @return int
     * @throws \yii\db\Exception
     */
    public static function update($id, $status, $execute_time = null, $result = null, $complete_time = null)
    {
        $data = [
            'status' => $status
        ];
        if (!empty($execute_time)) {
            $data = array_merge($data, [
                'execute_time' => $execute_time
            ]);
        }
        if (!empty($complete_time)) {
            $data = array_merge($data, [
                'complete_time' => $complete_time
            ]);
        }
        if (!empty($result)) {
            $data = array_merge($data, [
                'result' => $result
            ]);
        }
        return Yii::$app->db->createCommand()->update(self::$table, $data, [
            'id' => $id
        ])->execute();
    }

    /**
     * 处理超时任务
     * @return int
     * @throws \yii\db\Exception
     */
    public static function fail()
    {
        $time = date('Y-m-d H:i:s', strtotime('-60 seconds'));
        return Yii::$app->db->createCommand()->update(self::$table, [
            'status' => 3
        ], 'start_time < :start_time AND status = :status')->bindValues([
            ':start_time' => $time,
            ':status' => 1,
        ])->execute();
    }

    /**
     * 代理服务器执行任务
     * @param $task
     * @return bool
     */
    public static function execute($task)
    {
        $task = json_decode($task, true);
        if (empty($task['execute_time']) || empty($task['command']) || empty($task['id'])) return false;
        $after_time_ms = strtotime($task['execute_time']) - time();
        if ($after_time_ms <= 0) return false;
        swoole_timer_after($after_time_ms * 1000, function () use ($task) {
            // 修改任务状态（处理中）
            self::update($task['id'], 2, date('Y-m-d H:i:s'));
            // 执行指定任务
            swoole_async::exec($task['command'], function ($result, $status) use ($task) {
                // 修改任务状态（处理完成）
                self::update($task['id'], 4, null, $result, date('Y-m-d H:i:s'));
            });
        });

        return true;
    }
}
