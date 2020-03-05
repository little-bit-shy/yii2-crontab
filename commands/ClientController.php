<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\commands\task\ExecuteTask;
use yii\console\Controller;
use swoole_client;
use swoole_process;
use Swoole\Process;
use Yii;

/**
 * Class ClientController
 * @package app\commands
 */
class ClientController extends Controller
{
    public $host;
    public $port;
    public $sign;
    public $timeout;
    private $client;

    public function init()
    {
        parent::init();
        $config = Yii::$app->params['task'];
        $this->host = $config['client_host'];
        $this->port = $config['port'];
        $this->sign = $config['sign'];
        $this->timeout = $config['timeout'];
    }

    public function actionIndex()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP | SWOOLE_SSL, SWOOLE_SOCK_ASYNC);
        $this->client->set([
            'open_eof_split' => true,
            'package_eof' => "\r\n",
//            'ssl_allow_self_signed' => true,
//            'ssl_verify_peer' => true,
//            'ssl_cert_file' => __DIR__ . '/task/ca/users/client.crt',
//            'ssl_key_file' => __DIR__ . '/task/ca/users/client.key',
//            'ssl_host_name' => '',
//            'ssl_cert_file' => __DIR__ . '/task/ca/users/cer.pem',
//            'ssl_key_file' => __DIR__ . '/task/ca/users/key.pem',
//            'ssl_cafile' => __DIR__ . '/task/ca/server/server.crt',
//            'ssl_capath' => __DIR__ . '/task/ca/server',
        ]);
        $this->client->on('Error', [$this, 'onError']);
        $this->client->on('Connect', [$this, 'onConnect']);
        $this->client->on('Receive', [$this, 'onReceive']);
        $this->client->on('Close', [$this, 'onClose']);

        swoole_process::signal(SIGCHLD, function ($sig) {
            //必须为false，非阻塞模式，释放关闭子进程
            while ($ret = Process::wait(false)) {
            }
        });
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
        if ($this->checkSign($data)) {
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
    public function checkSign($data)
    {
        $data = json_decode($data, true);
        if (isset($data['sign'])) {
            $sign = $data['sign'];
            unset($data['sign']);
            asort($data);
            $tmpSign = serialize($data);
            $checkSign = md5($tmpSign . $this->sign);
            if ($checkSign == $sign) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
