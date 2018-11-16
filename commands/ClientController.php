<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\commands\task\ExecuteTask;
use Swoole\Coroutine;
use yii\console\Controller;
use swoole_client;

/**
 * Class ClientController
 * @package app\commands
 */
class ClientController extends Controller
{
    private $client;

    public function actionIndex()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP | SWOOLE_SSL, SWOOLE_SOCK_ASYNC);
        $this->client->set([
            'open_eof_split' => true,
            'package_eof' => "\r\n",
            'ssl_verify_peer' => true,
            'ssl_cafile' => __DIR__ . '/task/ssl/server.crt',
            'ssl_cert_file' => __DIR__ . '/task/ssl/client.crt',
            'ssl_key_file' => __DIR__ . '/task/ssl/client.key',
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
        echo $data;
        ExecuteTask::execute($data);
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
