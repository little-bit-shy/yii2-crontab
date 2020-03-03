<?php

namespace app\commands\task;

use app\components\ParseCrontab;
use swoole_server;
use Yii;
use yii\redis\Connection;

/**
 * 定义任务容器Table
 * Class Table
 * @package app\commands\task
 */
class Table
{
    public static $limit = 60;
    public static $key = 'swoole_task_list';

    /**
     * 往redis中追加需要执行的任务数据
     */
    public static function set()
    {
        // 分析两分钟后的任务
        $start_time = time() - (time() % 60) + (60 * 2);
        $tasks = Task::get();
        foreach ($tasks as $task) {
            $interval = null;
            $command = $task['command'];
            $rule = $task['rule'];
            $type = $task['type'];
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
                    'type' => $type,
                    'create_time' => $date,
                    'update_time' => $date
                ];
                // 添加任务数据到MySQL
                ExecuteTask::set($execute_task);

                $last_insert_id = ExecuteTask::getInsertId();
                $execute_task = json_encode([
                    'id' => $last_insert_id,
                    'execute_time' => date('Y-m-d H:i:s', $start_time + $value),
                    'command' => $command,
                    'type' => $type,
                ]);
                // 添加任务数据到 redis
                /** @var Connection $redis */
                $redis = Yii::$app->redis;
                $redis->lpush(self::$key, $execute_task);
            }
        }
    }

    /**
     * 获取最后一个元素并移除
     * @return bool|mixed
     */
    public static function one()
    {
        /** @var Connection $redis */
        $redis = Yii::$app->redis;
        $task = $redis->rpop(self::$key);
        if ($task === null) {
            return false;
        } else {
            return json_decode($task, true);
        }
    }
}
