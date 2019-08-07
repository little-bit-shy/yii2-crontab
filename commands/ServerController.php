<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\commands\task\ExecuteTask;
use app\commands\task\Table;
use app\components\ParseCrontab;
use yii\console\Controller;
use swoole_server;
use swoole_process;

/**
 * Class ServerController
 * @package app\commands
 */
class ServerController extends Controller
{
    public $host = '127.0.0.1';
    public $port = 9501;
    private $serv;

    public function actionIndex()
    {
        // Swoole Table 初始化
        Table::init();
        $this->serv = new swoole_server($this->host, $this->port, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
        $this->serv->set(array(
            'worker_num' => 8,
            'daemonize' => false,
            'task_worker_num' => 4, // 设置启动4个task进程
            'open_eof_split' => true,
            'package_eof' => "\r\n",
            'ssl_cert_file' => __DIR__ . '/task/ssl/server.crt',
            'ssl_key_file' => __DIR__ . '/task/ssl/server.key',
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
            Table::set($serv);
            $serv->tick(Table::$limit * 1000, function () use ($serv) {
                Table::set($serv);
            });
        });
        $this->serv->addProcess($process);

        // 分配任务数据
        $process = new swoole_process(function ($process) use ($serv) {
            $serv->tick(500, function () use ($serv) {
                $clientList = [];
                $start_fd = 0;
                while ($list = $serv->getClientList($start_fd, 100)) {
                    foreach ($list as $v) {
                        array_push($clientList, $v);
                    }
                    $start_fd = end($list);
                }
                $count = count($clientList);
                foreach (Table::$table as $id => $task) {
                    if ($count > 0) {
                        $remaining = $id % $count;
                        $serv->send($clientList[$remaining], json_encode($task) . "\r\n");
                        Table::$table->del($id);
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
}
