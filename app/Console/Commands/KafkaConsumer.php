<?php

namespace App\Console\Commands;

use App\Services\Kafka\KafkaService;
use Illuminate\Console\Command;

class KafkaConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from Kafka topic';

    // php artisan kafka:consume

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = app(KafkaService::class)->consumeMessage();
        $this->info('Received message: '.json_encode($message));
    }
}
