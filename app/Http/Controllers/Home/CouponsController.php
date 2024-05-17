<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponsController extends Controller
{

    public function receive()
    {
        return $this->handle(app(CouponService::class)->receive());
    }


    public function index()
    {
        return $this->success([]);
    }
}
