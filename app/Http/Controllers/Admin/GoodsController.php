<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\GoodsQuery;
use App\Http\Resources\Admin\GoodsCollection;
use App\Services\GoodsService;
use Illuminate\Http\Request;

class GoodsController extends Controller
{

    public function index(Request $request, GoodsQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success(new GoodsCollection($data));
    }

    public function show(Request $request, $id)
    {
        $rs = app(GoodsService::class)->getGoodsInfo($id, $request->all());
        return $this->handle($rs);
    }

    public function update(Request $request, $id)
    {
        $rs = app(GoodsService::class)->editGoods($id, $request->all(), 'admins');
        return $this->handle($rs);
    }


    public function applyStatus(Request $request)
    {
        return $this->handle(app(GoodsService::class)->applyStatus());
    }
}
