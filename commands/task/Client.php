<?php

namespace app\commands\task;

use Yii;
use yii\redis\Connection;

/**
 * 定义客户端信息Table
 * Class Table
 * @package app\commands\task
 */
class Client
{
    public static $time = 10;
    public static $key = 'swoole_client_list';

    /**
     * 更新客户端列表信息
     */
    public static function set($list)
    {
        $list = json_encode($list);
        /** @var Connection $redis */
        $redis = Yii::$app->redis;
        $redis->setex(self::$key, self::$time, $list);
    }

    /**
     * 获取最后一个元素并移除
     * @return bool|mixed
     */
    public static function get()
    {
        /** @var Connection $redis */
        $redis = Yii::$app->redis;
        $list = $redis->get(self::$key);
        if ($list === null) {
            return [];
        } else {
            return json_decode($list, true);
        }
    }
}
