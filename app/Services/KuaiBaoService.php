<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/17 21:14
 * description:
 */
namespace App\Services;

use GuzzleHttp\Client;

class KuaiBaoService extends BaseService
{
    public function getExpressInfo($delivery_no, $delivery_code, $phone)
    {
        $info = app(ConfigsService::class)->getFormatConfig('kuaibao');
        $url = 'https://kop.kuaidihelp.com/api';
        $appkey = $info['appkey'];
        $data['method'] = 'express.info.get';
        $data['app_id'] = $info['appid'];
        $data['ts'] = time();
        $data['sign'] = md5($data['app_id'] . $data['method'] . $data['ts'] . $appkey);
        $data2['waybill_no'] = $delivery_no;
        $data2['exp_company_code'] = $delivery_code;
        $data2['result_sort'] = 0;
        $data2['phone'] = substr($phone, -4);
        $data['data'] = json_encode($data2);
        $client = new Client(['verify' => false]); // 去掉证书验证
        $response = $client->request('POST', $url, ['form_params' => $data]);
        $info = $response->getBody();
        $infos = $info->getContents();
        $kbInfo = json_decode($infos, true);
        if ($kbInfo['code'] != 0) {
            return $this->formatError($kbInfo['msg']);
        }
        $data = $kbInfo['data'][0]['data'];
        return $this->format($data);
    }
}