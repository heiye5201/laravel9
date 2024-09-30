<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/27 16:03
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Kafka\KafkaService;
use Illuminate\Http\Request;

class KafkaController extends Controller
{

    public function produceMessage(Request $request)
    {
        // 生产消息到 Kafka
        $message = 'hello word jwj'; $request->input('message');
        app(KafkaService::class)->sendMessage($message);
        return response()->json(['message' => 'Message sent to Kafka']);
    }

    public function consumeMessage(Request $request)
    {
        // 生产消息到 Kafka
        $result = app(KafkaService::class)->consumeMessage();
        return response()->json(['message' => $result]);
    }

    public function consumeTest(Request $request)
    {
        // 生产消息到 Kafka
        $result = app(KafkaService::class)->consumeTest();
        return response()->json(['message' => $result]);
    }

}