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
                $start_time = date('Y-m-d H:i:s', $start_time + $value);
                ExecuteTask::pushTask($start_time, $command, $type);
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
        $config = Yii::$app->params['task'];
        $key = $config['key'];
        $task = $redis->rpop($key);
        if ($task === null) {
            return false;
        } else {
            return json_decode($task, true);
        }
    }
}
