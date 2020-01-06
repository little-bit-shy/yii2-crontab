<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/3
 * Time: 14:38
 */

namespace v1;

use Yii;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        // 从config.php加载配置来初始化模块
        $config = require(__DIR__ . '/config/config.php');
        $components = $config['components'];
        $params = $config['params'];
        // 重新配置相关组件
        Yii::$app->setComponents($components);
        Yii::$app->params = $params;
    }
}