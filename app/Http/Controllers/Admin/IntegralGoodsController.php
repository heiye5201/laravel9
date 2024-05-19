<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\Admin\IntegralGoodsQuery;
use App\Models\IntegralGoods;
use Illuminate\Http\Request;

class IntegralGoodsController extends Controller
{
    public function index(Request $request, IntegralGoodsQuery $query)
    {
        $data = $query->with(['class'])->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = IntegralGoods::query()->find($id);
        return $this->success($data);
    }

    public function store(Request $request)
    {
        try {
            $data = IntegralGoods::query()->create([
                'cid' => $request->input('cid'),
                'goods_name' => $request->input('goods_name'),
                'goods_subname' => $request->input('goods_subname'),
                'goods_price' => $request->input('goods_price', 0),
                'goods_market_price' => $request->input('goods_market_price', 0),
                'goods_stock' => $request->input('goods_stock', 0),
                'goods_images' => $request->input('goods_images', ''),
                'goods_master_image' => $request->input('goods_master_image'),
                'goods_sale' => $request->input('goods_sale', 0),
                'goods_status' => $request->input('goods_status', 0) ?? false,
                'is_recommend' => $request->input('is_recommend', 0) ?? false,
                'goods_content' => $request->input('goods_content', ''),
            ]);
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = IntegralGoods::query()->where('id', $id)->update([
                'cid' => $request->input('cid'),
                'goods_name' => $request->input('goods_name'),
                'goods_subname' => $request->input('goods_subname'),
                'goods_price' => $request->input('goods_price', 0),
                'goods_market_price' => $request->input('goods_market_price', 0),
                'goods_stock' => $request->input('goods_stock', 0),
                'goods_images' => $request->input('goods_images', ''),
                'goods_master_image' => $request->input('goods_master_image'),
                'goods_sale' => $request->input('goods_sale', 0),
                'goods_status' => $request->input('goods_status', false),
                'is_recommend' => $request->input('is_recommend', false),
                'goods_content' => $request->input('goods_content', ''),
            ]);
            return $this->handle(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $ids = explode(",", $id);
            $data = IntegralGoods::query()->whereIn('id', $ids)->delete();
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
