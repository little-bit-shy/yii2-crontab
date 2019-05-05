<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/4/26
 * Time: 19:31
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\console\Exception;

/**
 * Class Kafka
 * @package app\components
 */
class Kafka extends Component
{
    /**
     * @var string 配置kafka，可以用逗号隔开多个kafka，示例：'127.0.0.1:9092,127.0.0.1:9092'
     */
    public $broker_list = null;//配置kafka，可以用逗号隔开多个kafka

    /**
     * 生产者对象
     * @var null
     */
    private $producer = null;

    /**
     * 获取kafka驱动
     * @param string $componentId
     * @return Kafka
     * @throws \yii\base\InvalidConfigException
     */
    public static function getClass($componentId = 'kafka')
    {
        /** @var self $kafka */
        $kafka = Yii::$app->get($componentId);
        return $kafka;
    }

    /**
     * 实例化\RdKafka\Producer
     */
    public function init()
    {
        $rk = new \RdKafka\Producer();
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->broker_list);
        $this->producer = $rk;
    }

    /**
     * 生产者
     * @param $topic
     * @param int $partition
     * @param array $messages
     * @param int $requestRequiredAcks Kafka producer的ack有3中机制，初始化producer时的producerconfig可以通过配置request.required.acks不同的值来实现。
     * 0：这意味着生产者producer不等待来自broker同步完成的确认继续发送下一条（批）消息。此选项提供最低的延迟但最弱的耐久性保证（当服务器发生故障时某些数据会丢失，如leader已死，但producer并不知情，发出去的信息broker就收不到）。
     * 1：这意味着producer在leader已成功收到的数据并得到确认后发送下一条message。此选项提供了更好的耐久性为客户等待服务器确认请求成功（被写入死亡leader但尚未复制将失去了唯一的消息）。
     * -1：这意味着producer在follower副本确认接收到数据后才算一次发送完成。
     * 此选项提供最好的耐久性，我们保证没有信息将丢失，只要至少一个同步副本保持存活。
     * 三种机制，性能依次递减 (producer吞吐量降低)，数据健壮性则依次递增。
     * @return mixed
     */
    public function send($topic, $messages = [], $requestRequiredAcks = -1)
    {
        $cf = new \RdKafka\TopicConf();
        $cf->set('request.required.acks', $requestRequiredAcks);
        $topic = $this->producer->newTopic($topic, $cf);
        /** RD_KAFKA_PARTITION_UA 代表 未分配，并让librdkafka选择分区 */
        return $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($messages));
    }

    /**
     * 高级消费者，数据节点等数据由zookeeper处理
     * @param array $topic
     * @param object $object
     * @param string $callback
     * @param string $groupId
     * @param string $autoOffsetReset
     * @throws \Exception
     */
    public function consumerHighLevel($topic = [], $object, $callback, $groupId = '0', $autoOffsetReset = 'smallest')
    {
        $conf = new \RdKafka\Conf();
        // 分配/撤销 分区
        $conf->setRebalanceCb(function (\RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
            switch ($err) {
                case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
                    echo "Assign: ";
                    var_dump($partitions);
                    $kafka->assign($partitions);
                    break;
                case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
                    echo "Revoke: ";
                    var_dump($partitions);
                    $kafka->assign(NULL);
                    break;
                default:
                    throw new Exception($err);
            }
        });
        $conf->set('group.id', $groupId);
        $conf->set('metadata.broker.list', $this->broker_list);

        $topicConf = new \RdKafka\TopicConf();
        $topicConf->set('auto.offset.reset', $autoOffsetReset);
        // Set the configuration to use for subscribed/assigned topics
        $conf->setDefaultTopicConf($topicConf);

        $consumer = new \RdKafka\KafkaConsumer($conf);
        $consumer->subscribe($topic);
        echo "Waiting for partition assignment... (make take some time when", PHP_EOL;
        echo "quickly re-joining the group after leaving it.)", PHP_EOL;
        while (true) {
            $message = $consumer->consume(10 * 1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    echo "message payload....", PHP_EOL;
                    $object->$callback($message->payload);
                    echo PHP_EOL;
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more", PHP_EOL;
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out", PHP_EOL;
                    break;
                default:
                    throw new Exception($message->errstr());
                    break;
            }
        }
    }

    /**
     * 低级消费者，数据节点等数据客户端决定如何处理
     * @param array $topic
     * @param object $object
     * @param string $callback
     * @param string $groupId
     * @param int $partition
     * @param int $offset
     * @throws Exception
     */
    public function consumerLowLevel($topic, $object, $callback, $groupId = '0', $partition = 0, $offset = 0)
    {
        $conf = new \RdKafka\Conf();

        $conf->set('group.id', $groupId);

        $rk = new \RdKafka\Consumer($conf);
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->broker_list);

        $topicConf = new \RdKafka\TopicConf();
        // Disable committing offsets automatically
        $topicConf->set('auto.commit.enable', 'false');
        $topic = $rk->newTopic($topic, $topicConf);

        // The first argument is the partition to consume from.
        // The second argument is the offset at which to start consumption. Valid values
        // are: RD_KAFKA_OFFSET_BEGINNING, RD_KAFKA_OFFSET_END, RD_KAFKA_OFFSET_STORED.
        $topic->consumeStart($partition, $offset);

        while (true) {
            // The first argument is the partition (again).
            // The second argument is the timeout.
            $message = $topic->consume($partition, 10 * 1000);
            if (null === $message) {
                continue;
            } elseif ($message->err) {
                throw new Exception($message->errstr());
                break;
            } else {
                echo "message payload....", PHP_EOL;
                echo "offset: " . $message->offset, PHP_EOL;
                $object->$callback($message->payload);
                echo PHP_EOL;
            }
        }
    }
}