<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\ArrayHelper;
use app\components\FileHelper;
use app\components\StringHelper;
use app\models\DynamicModel;
use Yii;
use yii\console\Exception;
use yii\console\ExitCode;

/**
 * Class Controller
 * @package app\commands
 */
class Controller extends \yii\console\Controller
{
    /**
     * @var string 执行的操作
     */
    public $some;

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        $options = parent::options($actionID);
        return array_merge($options, [
            'some'
        ]);
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        $optionAliases = parent::optionAliases();
        return array_merge($optionAliases, [
            's' => 'some'
        ]);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws Exception
     */
    public function beforeAction($action)
    {
        $model = new DynamicModel([
            'some' => $this->some
        ]);
        $model->addRule('some', 'default', ['value' => 'start'])
            ->addRule('some', 'required')
            ->addRule('some', 'string')
            ->addRule('some', 'in', ['range' => ['start', 'stop', 'restart']])
            ->validate();
        if ($model->hasErrors()) {
            throw new Exception($model->getFirstError(), 500);
        }
        $attributes = $model->getAttributes();
        $this->some = $attributes['some'];
        return parent::beforeAction($action);
    }

    /**
     * 获取当前进程id
     * @return int
     */
    public function getPid()
    {
        return posix_getpid();
    }

    /**
     * 返回pid文件路由
     * @return string
     */
    public function getPidFile()
    {
        $uniqueId = $this->action->getUniqueId();
        $pidPath = Yii::$app->getRuntimePath() . '/pid/';
        FileHelper::createDirectory($pidPath);
        return $pidPath . StringHelper::replace('/', '_', $uniqueId) . '.pid';

    }

    /**
     * pid文件中获取进程id
     * @return array
     */
    public function getPid2File()
    {
        $pidFile = $this->getPidFile();
        @$pidString = file_get_contents($pidFile);
        $pids = ArrayHelper::removeNull(StringHelper::explode($pidString, PHP_EOL));
        return $pids;
    }

    /**
     * 进程id写入pid文件，多个进程id分行存储
     */
    public function setPid2File($pid = null)
    {
        if (empty($pid)) {
            $pid = $this->getPid();
        }
        $pidFile = $this->getPidFile();
        file_put_contents($pidFile, $pid . PHP_EOL, FILE_APPEND);
    }

    /**
     * 清空pid文件进程id数据
     */
    public function delPid2File()
    {
        $pidFile = $this->getPidFile();
        $pids = $this->getPid2File();
        ArrayHelper::mapForeach(function ($value) {
            // 终止信号
            posix_kill($value, SIGTERM);
        }, $pids);
        file_put_contents($pidFile, '');
    }

    /**
     * 验证pid文件进程id是否运行中
     */
    public function checkPid2File()
    {
        $pidFile = $this->getPidFile();
        $pids = $this->getPid2File();
        foreach ($pids as $pid) {
            if (FileHelper::fileExists(('/proc/' . $pid))) {
                return true;
            }
        }
        file_put_contents($pidFile, '');
        return false;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function checkSome(){
        switch ($this->some) {
            case 'start':
                if ($this->checkPid2File()) {
                    throw new Exception('the pid file is not empty, the server is running?', 500);
                } else {
                    $this->setPid2File();
                }
                break;
            case 'stop':
                $this->delPid2File();
                break;
            case 'restart':
                $this->delPid2File();
                // 等待旧进程终止
                sleep(1);
                $this->setPid2File();
                break;
        }

        return $this->some;
    }
}
