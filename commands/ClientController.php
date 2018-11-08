<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use swoole_server;
use swoole_client;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ClientController extends Controller
{
    private $client;

    public function actionIndex()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->set([
            'open_eof_split' => true,
            'package_eof' => "\r\n",
        ]);
        $this->client->on('Error', [$this, 'onError']);
        $this->client->on('Connect', [$this, 'onConnect']);
        $this->client->on('Receive', [$this, 'onReceive']);
        $this->client->on('Close', [$this, 'onClose']);
        $this->client->connect("127.0.0.1", 9501, 1);
    }

    /**
     * @param $cli
     */
    public function onConnect($cli)
    {
        echo "connect success!\n";
    }

    /**
     * @param $cli
     * @param $data
     */
    public function onReceive($cli, $data)
    {
        $task = json_decode($data, true);
        if (!empty($task)) {
            echo "收到任务：{$task['command']}\n";
        }
    }

    /**
     * @param $cli
     */
    public function onClose($cli)
    {
        echo "Client close connection\n";
    }

    /**
     * @param $cli
     */
    public function onError($cli)
    {
        echo "Client error\n";
    }


}
