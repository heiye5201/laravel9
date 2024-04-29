<?php
/**
 * autor      : jiweijian
 * createTime : 2024/4/29 10:32
 * description:
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    
    public function index(Request $request)
    {
        $data['web_name'] = '夜听雨商城';
        $data['index_name'] = '夜听雨商城';
        $data['keyword'] = '夜听雨';
        $config = ['status'=>true,'data'=>$data,'msg'=>'success'];
        return view('vue', $config['status'] ? $config['data'] : []);
    }
}