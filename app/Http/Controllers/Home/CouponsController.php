<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Queries\CouponsQuery;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponsController extends Controller
{

    public function receive()
    {
        return $this->handle(app(CouponService::class)->receive());
    }

    public function index(Request $request, CouponsQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }
}
