<?php
namespace app\commands\task;

use Yii;
use yii\db\Query;
use swoole_async;
use swoole_process;
use Swoole\Process;

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
    private static $user_table = 'yii2_user';
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
        Yii::$app->db->createCommand()->update(self::$table, $data, [
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
        // 未开始超时任务失败
        $time = date('Y-m-d H:i:s', strtotime('-60 seconds'));
        Yii::$app->db->createCommand()->update(self::$table, [
            'status' => 3
        ], 'start_time < :start_time AND status = :status')->bindValues([
            ':start_time' => $time,
            ':status' => 1,
        ])->execute();

//        // 未完成超时任务失败
//        $time = date('Y-m-d H:i:s', strtotime('-3600 seconds'));
//        Yii::$app->db->createCommand()->update(self::$table, [
//            'status' => 3
//        ], 'start_time < :start_time AND status = :status')->bindValues([
//            ':start_time' => $time,
//            ':status' => 2,
//        ])->execute();
    }

    /**
     * 处理异常任务预警通知
     * @return int
     * @throws \yii\db\Exception
     */
    public static function warning()
    {
        // 组装邮件内容
        $warningtTasks = (new Query())->from(self::$table)
            ->where([
                'status' => 3,
                'warning' => 2,
            ])
            ->all();
        $a = Yii::t('app/message', 'id');
        $b = Yii::t('app/message', 'error task');
        $c = Yii::t('app/message', 'plan execute time');
        $d = Yii::t('app/message', 'practical execute time');
        $body = "";
        $ids = [];
        foreach ($warningtTasks as $task) {
            $ids[] = $task['id'];
            $body .= <<<TEXT
{$a}：{$task['id']}
{$c}：{$task['start_time']}
{$d}：{$task['execute_time']}
{$b}：
{$task['command']}
--------------------------------------------------------------------

TEXT;
        }

        // 组件邮件接收人
        $messages = [];
        if (!empty($body)) {
            $users = (new Query())->from(self::$user_table)
                ->select(['email'])
                ->where([
                    'warning' => 1
                ])
                ->all();
            foreach ($users as $user) {
                if (!empty($user['email'])) {
                    $messages[] = Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setSubject(Yii::t('app/message', 'system warning'))
                        ->setTextBody($body)
                        ->setTo($user['email']);
                }
            }
        }
        // 异常捕获
        try {
            Yii::$app->mailer->sendMultiple($messages);
        } catch (\Exception $e) {

        }
        // 标记预警状态
        Yii::$app->db->createCommand()->update(self::$table, [
            'warning' => 1
        ], [
            'in', 'id', $ids
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
        if (empty($task['execute_time']) || empty($task['command']) || empty($task['id']) || empty($task['type'])) return false;
        $after_time_ms = strtotime($task['execute_time']) - time();
        if ($after_time_ms <= 0) return false;
        swoole_timer_after($after_time_ms * 1000, function () use ($task) {
            // 创建临时文件
            $tmpFile = tempnam("/tmp/", "task_");
            file_put_contents($tmpFile, $task['command']);

            $process = new Process(function (Process $childProcess) use ($task, $tmpFile) {
                // 修改任务状态（处理中）
                self::update($task['id'], 2, date('Y-m-d H:i:s'));
                switch ($task['type']) {
                    case 1:
                        $command = "bash $tmpFile";
                        break;
                    case 2:
                        $command = "python $tmpFile";
                        break;
                }

                swoole_async::exec($command, function ($result, $status) use ($childProcess, $task, $tmpFile) {
                    // 修改任务状态（处理完成）
                    if ($status['code'] == 0) {
                        self::update($task['id'], 4, null, $result, date('Y-m-d H:i:s'));
                    } else {
                        self::update($task['id'], 3);
                    }
                    // 删除临时文件
                    unlink($tmpFile);
                    $childProcess->exit();
                });
            }, true);
            $process->start();
        });

        return true;
    }
}
