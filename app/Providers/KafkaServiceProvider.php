<?php

namespace App\Providers;

use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Illuminate\Support\ServiceProvider;
use Interop\Queue\Context;

class KafkaServiceProvider extends ServiceProvider
{

    protected $kafkaContext;


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register Kafka Context
        $this->app->singleton(Context::class, function ($app) {
            if ($this->kafkaContext === null) {
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
                $this->kafkaContext = $connectionFactory->createContext();
            }
            return $this->kafkaContext;
        });

        // Register Kafka Producer
        $this->app->singleton('kafka-producer', function ($app) {
            return $app->make(Context::class);
        });

        // Register Kafka Consumer
        $this->app->singleton('kafka-consumer', function ($app) {
            $context = $app->make(Context::class);
            $fooQueue = $context->createQueue('foo');
            return $context->createConsumer($fooQueue);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
