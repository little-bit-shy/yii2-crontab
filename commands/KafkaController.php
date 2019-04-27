<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/4/26
 * Time: 19:37
 * @desc 生产者（kafka）
 */

namespace app\commands;

use app\components\Kafka;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class KafkaController
 * @package app\commands
 */
class KafkaController extends Controller
{
    /**
     * kafka生产者
     * @throws \yii\base\InvalidConfigException
     */
    public function actionProducer()
    {
        Kafka::getClass()->send('test', [date('Y-m-d H:i:s')]);
    }

    /**
     * kafka消费者
     * @throws \yii\base\InvalidConfigException
     */
    public function actionConsumer()
    {
        Kafka::getClass()->consumer(['test'], $this, 'consumerCallback', 'myConsumerGroup');
    }

    public function consumerCallback($message)
    {
        $this->stdout("{$message}\n", Console::BG_GREEN);
    }
}
