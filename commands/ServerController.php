<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\commands\task\Client;
use app\commands\task\ExecuteTask;
use app\commands\task\Table;
use swoole_server;
use swoole_process;
use Yii;
use yii\console\Exception;
use yii\console\ExitCode;

/**
 * 异步任务服务端
 * @package app\commands
 */
class ServerController extends Controller
{
    public $host;
    public $port;
    public $sign;
    private $serv;

    public function init()
    {
        parent::init();
        $config = Yii::$app->params['task'];
        $this->host = $config['server_host'];
        $this->port = $config['port'];
        $this->sign = $config['sign'];
    }

    public function actionIndex()
    {
        $this->checkSome();
        if ($this->some == 'stop') {
            return ExitCode::OK;
        }

        $this->serv = new swoole_server($this->host, $this->port, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
        $this->serv->set(array(
            'worker_num' => 8,
            'daemonize' => false,
            'task_worker_num' => 4,
            'open_eof_split' => true,
            'package_eof' => "\r\n",
            'ssl_verify_peer' => true,
            'ssl_allow_self_signed' => true,
            'ssl_cert_file' => __DIR__ . '/task/ca/server/server.crt',
            'ssl_key_file' => __DIR__ . '/task/ca/server/server.key',
            'ssl_client_cert_file' => __DIR__ . '/task/ca/private/ca.crt',
            'ssl_verify_depth' => 10,
        ));

        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Close', [$this, 'onClose']);
        $this->serv->on('Task', [$this, 'onTask']);
        $this->serv->on('Finish', [$this, 'onFinish']);
        $this->serv->on('workerStart', [$this, 'onWorkerStart']);
        $this->serv->on('pipeMessage', [$this, 'onPipeMessage']);
        $serv = $this->serv;

        // 准备任务数据
        $process = new swoole_process(function ($process) use ($serv) {
            Table::set();
            $serv->tick(60000, function () use ($serv) {
                Table::set();
            });
        });
        $this->serv->addProcess($process);

        // 分配任务数据
        $process = new swoole_process(function ($process) use ($serv) {
            $serv->tick(500, function () use ($serv) {
                $clientList = [];
                $clientListInfo = [];
                $start_fd = 0;
                while ($list = $serv->getClientList($start_fd, 100)) {
                    foreach ($list as $fd) {
                        array_push($clientList, $fd);
                        array_push($clientListInfo, $serv->getClientInfo($fd));
                    }
                    $start_fd = end($list);
                }
                $count = count($clientList);
                Client::set($clientListInfo);
                if ($count > 0) {
                    while ($task = Table::one()) {
                        $remaining = $task['id'] % $count;
                        $this->addSign($task);
                        $serv->send($clientList[$remaining], json_encode($task) . "\r\n");
                    }
                }
            });
        });
        $this->serv->addProcess($process);

        // 处理超时任务
        $process = new swoole_process(function ($process) use ($serv) {
            ExecuteTask::fail();
            $serv->tick(60000, function () use ($serv) {
                ExecuteTask::fail();
            });
        });
        $this->serv->addProcess($process);

        // 处理异常任务预警通知
        $process = new swoole_process(function ($process) use ($serv) {
            $serv->tick(60000, function () use ($serv) {
                ExecuteTask::warning();
            });
        });
        $this->serv->addProcess($process);

        $this->serv->start();
    }

    /**
     * @param $serv swoole_server swoole_server对象
     */
    public function onStart($serv)
    {
        echo "Start\n";
    }

    /**
     * @param $serv swoole_server swoole_server对象
     * @param $fd int 是TCP客户端连接的标识符
     * @param $from_id int 投递任务的worker_id
     */
    public function onConnect($serv, $fd, $from_id)
    {
        echo "have connect!\n";
    }

    /**
     * @param $serv swoole_server swoole_server对象
     * @param $fd int 是TCP客户端连接的标识符
     * @param $from_id int 投递任务的worker_id
     * @param $data string 接收到的数据
     */
    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get Message From Client {$fd}:{$data}\n";
    }

    /**
     * @param $serv swoole_server swoole_server对象
     * @param $fd int 是TCP客户端连接的标识符
     * @param $from_id int 投递任务的worker_id
     */
    public function onClose($serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }

    /**
     * @param $serv swoole_server swoole_server对象
     * @param $task_id int 任务id
     * @param $from_id int 投递任务的worker_id
     * @param $data string 投递的数据
     */
    public function onTask(swoole_server $serv, $task_id, $from_id, $data)
    {
        echo "onTask\n";
        $serv->finish($data);
    }

    /**
     * @param $serv swoole_server swoole_server对象
     * @param $task_id int 任务id
     * @param $data string 任务返回的数据
     */
    public function onFinish(swoole_server $serv, $task_id, $data)
    {
        echo "onFinish\n";
    }

    /**
     * @param $serv swoole_server swoole_server对象
     * @param $worker_id
     */
    public function onWorkerStart($serv, $worker_id)
    {
        if ($worker_id >= $serv->setting['worker_num']) {
            swoole_set_process_name("swoole : task_worker");
        } else {
            swoole_set_process_name("swoole : worker");
        }

    }

    /**
     * 添加签名
     * @param $data
     */
    public function addSign(&$data)
    {
        asort($data);
        $tmpSign = serialize($data);
        $sign = md5($tmpSign . $this->sign);
        $data['sign'] = $sign;
    }
}
