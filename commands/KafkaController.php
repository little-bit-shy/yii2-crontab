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
use app\models\DynamicModel;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;

/**
 * Class KafkaController
 * @package app\commands
 */
class KafkaController extends Controller
{
    /**
     * @var int 消费者指定需要消费的分区id
     */
    public $partition;

    public function options($actionID)
    {
        $options = parent::options($actionID);
        return array_merge($options, [
            'partition'
        ]);
    }

    public function optionAliases()
    {
        $optionAliases = parent::optionAliases();
        return array_merge($optionAliases, [
            'p' => 'partition'
        ]);
    }

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
     * @throws \yii\console\Exception
     */
    public function actionConsumer()
    {
        $model = new DynamicModel([
            'partition' => $this->partition
        ]);
        $model->addRule('partition', 'required')
            ->addRule('partition', 'integer')
            ->validate();
        if ($model->hasErrors()) {
            throw new Exception($model->getFirstError(), 500);
        }
        Kafka::getClass()->consumerLowLevel('test', $this, 'consumerCallback', 'myConsumerGroup', $this->partition);
    }

    public function consumerCallback($message)
    {
        $this->stdout("{$message}", Console::BG_GREEN);
    }
}
