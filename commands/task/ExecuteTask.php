<?php
namespace app\commands\task;

use Yii;
use yii\db\Query;

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
}
