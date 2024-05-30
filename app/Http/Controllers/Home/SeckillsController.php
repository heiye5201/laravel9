<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\GoodsService;
use Illuminate\Http\Request;

class SeckillsController extends Controller
{

    public function index(Request $request)
    {
        return $this->handle(app(GoodsService::class)->getHomeSeckillGoods($request->all()));
    }
}
