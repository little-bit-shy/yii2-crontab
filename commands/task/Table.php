<?php

namespace app\commands\task;

use app\components\ParseCrontab;
use swoole_server;
use swoole_table;

/**
 * 定义任务容器Table
 * Class Table
 * @package app\commands\task
 */
class Table
{
    /** @var $table swoole_table */
    public static $table = null;
    public static $limit = 60;
    private static $size = 16384;
    private static $columns = [
        ['id', swoole_table::TYPE_INT, 11],
        ['command', swoole_table::TYPE_STRING, 255],
        ['execute_time', swoole_table::TYPE_STRING, 20]
    ];

    /**
     * 创建 Swoole Table
     * Table constructor.
     */
    public static function init()
    {
        if (!empty(self::$table)) {
            return;
        }
        self::$table = new swoole_table(self::$size);
        foreach (self::$columns as $column) {
            list($name, $type, $num) = array_values($column);
            self::$table->column($name, $type, $num);
        }
        self::$table->create();
    }

    /**
     * 往表中追加需要执行的任务数据
     * @param swoole_server $serv
     */
    public static function set(swoole_server $serv)
    {
        $start_time = time() - (time() % 60) + 60 + 60;
        $tasks = Task::get();
        $task_id = 0;
        foreach ($tasks as $task) {
            $interval = null;
            list($command, $rule) = array_values($task);
            $parseCrontab = ParseCrontab::parse($rule, $start_time);
            if ($parseCrontab === false || $parseCrontab === null) {
                continue;
            }
            // 当前任务需要在self::$limit秒后的1分钟内执行
            foreach ($parseCrontab as $value) {
                $date = date('Y-m-d H:i:s');
                $execute_task = [
                    'start_time' => date('Y-m-d H:i:s', $start_time + $value),
                    'command' => $command,
                    'create_time' => $date,
                    'update_time' => $date
                ];
                // 添加任务数据到MySQL
                ExecuteTask::set($execute_task);

                $last_insert_id = ExecuteTask::getInsertId();
                $execute_task = [
                    'id' => $last_insert_id,
                    'execute_time' => date('Y-m-d H:i:s', $start_time + $value),
                    'command' => $command,
                ];
                // 避免key导致内存溢出
                ++$task_id;
                // 添加任务数据到 Swoole Table
                self::$table->set($task_id, $execute_task);
            }
        }
    }
}
