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
    public $host = '127.0.0.1';
    public $port = 9501;
    public static $sign = '1gf281f01gf0120gf2101';
    public $timeout = 1;
    private $client;

    public function actionIndex()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP | SWOOLE_SSL, SWOOLE_SOCK_ASYNC);
        $this->client->set([
            'open_eof_split' => true,
            'package_eof' => "\r\n",
        ]);
        $this->client->on('Error', [$this, 'onError']);
        $this->client->on('Connect', [$this, 'onConnect']);
        $this->client->on('Receive', [$this, 'onReceive']);
        $this->client->on('Close', [$this, 'onClose']);
        $this->client->connect($this->host, $this->port, $this->timeout);
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
        if (self::checkSign($data)) {
            ExecuteTask::execute($data);
        } else {
            $cli->close();
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

    /**
     * 验证签名
     * @param $data
     * @return bool
     */
    public static function checkSign($data)
    {
        $data = json_decode($data, true);
        if (isset($data['sign']) && $data['sign'] = self::$sign) {
            return true;
        } else {
            return false;
        }
    }
}
