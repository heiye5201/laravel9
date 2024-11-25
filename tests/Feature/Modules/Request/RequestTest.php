<?php
/**
 * autor      : jiweijian
 * createTime : 2024/10/16 15:26
 * description:
 */
namespace Tests\Feature\Modules\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }


    /**
     * GuzzleHttp请求报错不重置rewind，获得不到内容
     * php artisan test --filter testRequest tests/Feature/Modules/Request/RequestTest.php
     * @test
     * @return void
     */
    public function testRequest()
    {
        try {
            $client = new Client([
                'timeout'         => 60,
                'connect_timeout' => 60,
                'read_timeout'    => 60
            ]);
            $response = $client->request('GET', 'http://edu.jwj.com/api/comment/save');
            // 获取响应的状态码
            $statusCode = $response->getStatusCode();
            // 获取响应内容
            $body = $response->getBody()->getContents();
            print_r(['code'=>$statusCode, 'body'=>$body]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $body = $response->getBody();
            $contents = $body->getContents();
            Log::error('abc', $contents);
            $body->rewind(); // 这里需要将指针重置
            throw $e;
        }
    }


    /**
     * GuzzleHttp请求报错重置rewind，可以获得到内容
     * php artisan test --filter second tests/Feature/Modules/Request/RequestTest.php
     * @test
     * @return void
     */
    public function second()
    {
        try {
            $this->testRequest();
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $body = $response->getBody();
            $contents = $body->getContents(); // 如果上面没有重置指针，那么这里的 $contents 是空的
            throw $e;
        }
    }


    /**
     * 为什么不重置回获得不到内容，其核心原因是由于其read方法使用fread实现的，以下是fread实现测试
     * fread方法使用测试
     * php artisan test --filter testFreadMethod tests/Feature/Modules/Request/RequestTest.php
     * @test
     * @return void
     */
    public function testFreadMethod()
    {
        // 创建一个内存流
        $stream = fopen('php://temp', 'r+');
        // 向流中写入数据
        fwrite($stream, "Hello, World! My name is Guzzle");
        rewind($stream); // 将指针重置到流的开始
        // 读取数据
        $contents = fread($stream, 5); // 读取前5个字节
        print_r(['result'=>$contents]); // 输出: Hello

        // 指针现在在读取的末尾
        $position = ftell($stream); // 获取当前指针位置
        print_r(['position'=>$position]); // 输出: 5

        $remaining = fread($stream, 1024); // 由于没有重置指针，继续读取剩余字节后的1024个字节数据
        print_r(['remaining'=>$remaining]);  // 输出: , World!  My name is Guzzle

        // 重新读取内容之前需要重置指针
        rewind($stream); // 将指针重置回开始
        $allContents = fread($stream, 1024); // 读取1024个字节数据
        print_r(['allContents'=>$allContents]);  // 输出: Hello, World!  My name is Guzzle
        fclose($stream); // 关闭流
    }
}