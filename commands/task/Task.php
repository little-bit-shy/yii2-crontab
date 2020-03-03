<?php
namespace app\commands\task;

use yii\db\Query;

/**
 * 获取源任务数据
 * Class Task
 * @package app\commands\task
 */
class Task
{
    private static $select = [
        'command',
        'rule',
        'type',
    ];
    private static $table = 'yii2_task';
    private static $where = [
        'switch' => 1
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
}
