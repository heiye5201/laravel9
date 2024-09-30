<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/27 16:10
 * description: kafka服务
 */
namespace App\Services\Kafka;

use Enqueue\RdKafka\RdKafkaConnectionFactory;

class KafkaService
{

    /**
     * 创建kafka上下文
     * @return \Enqueue\RdKafka\RdKafkaContext|\Interop\Queue\Context
     */
    public function createConnection()
    {
        // connect to Kafka broker at example.com:1000 plus custom options
        $connectionFactory = new RdKafkaConnectionFactory([
            'global' => [
                'group.id' => 'kafka_group_id', //uniqid('kafka', true),
                'metadata.broker.list' => '127.0.0.1:9092',
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => 'beginning',
            ],
        ]);
        return $connectionFactory->createContext();
    }

    /**
     * 生产kafka主题消息
     * @param $msg
     * @return void
     */
    public function sendTop($msg)
    {
        $producer = app('kafka-producer');
        $message = $producer->createMessage($msg);
        $fooTopic = $producer->createTopic('foo');
        $producer->createProducer()->send($fooTopic, $message);
    }

    /**
     * 生产kafka消息
     * @param $msg
     * @return void
     */
    public function sendMessage($msg)
    {
        $producer = app('kafka-producer');
        $message = $producer->createMessage($msg);
        $fooQueue = $producer->createQueue('foo');
        $producer->createProducer()->send($fooQueue, $message);
    }

    /**
     * 消费kafka消息
     * @return void
     */
    public function consumeMessage()
    {
        $consumer = app('kafka-consumer');
//        $consumer->setCommitAsync(true);
        $message = $consumer->receive();
        // process a message
        $consumer->acknowledge($message);
        return $message;
//        $consumer->reject($message);
//        return $message;
    }


    public function consumeTest()
    {
        // connect to Kafka broker at example.com:1000 plus custom options
        $connectionFactory = new RdKafkaConnectionFactory([
            'global' => [
                'group.id' => 'kafka_group_id', //uniqid('kafka', true),
                'metadata.broker.list' => '127.0.0.1:9092',
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => 'beginning',
            ],
        ]);
        /** @var \Enqueue\RdKafka\RdKafkaContext $context */
        $context = $connectionFactory->createContext();
        $fooQueue = $context->createQueue('foo');
        $consumer = $context->createConsumer($fooQueue);
//        $consumer->setOffset(123);
        $message = $consumer->receive(500);
        $consumer->acknowledge($message);
        return $message;
//        if ($message) {
//            // Process the message
//            $consumer->acknowledge($message);
//            // 手动提交偏移量
//            $context->commit();
//            return $message;
//        } else {
//            return null;
//        }
    }

}