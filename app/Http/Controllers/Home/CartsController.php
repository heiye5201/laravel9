<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\StoreService;
use Illuminate\Http\Request;

class CartsController extends Controller
{

    public function index(Request $request)
    {
        return $this->handle(app(CartService::class)->getCart());
    }

    public function store(Request $request)
    {
        return $this->handle(app(CartService::class)->addCart());
    }

    public function update(Request $request, $id)
    {
        return $this->handle(app(CartService::class)->editCart($id));
    }

    public function count()
    {
        return $this->handle(app(CartService::class)->getCount());
    }


    public function destroy($id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $idArray = array_filter(explode(',', $id), function ($item) {
            return (is_numeric($item));
        });
        $res = Cart::query()->where('store_id', $storeId)
            ->whereIn('id', $idArray)->delete();
        return $this->success($res);
    }
}
