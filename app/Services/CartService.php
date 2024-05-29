<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 21:25
 * description:
 */

namespace App\Services;

use App\Http\Resources\Home\CartAppCollection;
use App\Http\Resources\Home\CartHomeCollection;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\GoodsSku;
use Illuminate\Support\Facades\DB;

class CartService extends BaseService
{

    // 获取购物车列表
    public function getCart($requestData)
    {
        // 获取当前用户user_id
        $userId = $this->getUserId('users');
        $cartList = Cart::query()->where('user_id', $userId)
            // 获取店铺信息
            ->with(['store' => function ($q) {
                return $q->select('id', 'store_name', 'store_logo');
            }, 'carts' => function ($q) use ($userId) {// 获取同一店铺的购物车数据
                return $q->where('user_id', $userId)->with(['goods' => function ($query) {
                    $query->select('id', 'goods_name', 'goods_master_image', 'goods_price');
                }, 'goods_sku' => function ($query) {
                    $query->select('id', 'sku_name', 'goods_image', 'goods_price');
                }]);
            }])->select(['store_id'])
            ->groupBy('store_id')
            ->paginate($requestData['per_page'] ?? 30);
        return $this->format(new CartHomeCollection($cartList));
    }


    // 获取购物车列表
    public function getCartApp()
    {
        // 获取当前用户user_id
        $userId = $this->getUserId('users');
        $cartList = Cart::query()->where(['user_id' => $userId])
            // 获取店铺信息
            ->with(['store' => function ($q) {
                return $q->select('id', 'store_name', 'store_logo');
            }, 'carts' => function ($q) use ($userId) {// 获取同一店铺的购物车数据
                return $q->where('user_id', $userId)->with(['goods' => function ($query) {
                    $query->select('id', 'goods_name', 'goods_master_image', 'goods_price');
                }, 'goods_sku' => function ($query) {
                    $query->select('id', 'sku_name', 'goods_image', 'goods_price');
                }]);
            }])
            ->groupBy('store_id')
            ->paginate(30);
        return $this->format(new CartAppCollection($cartList));
    }

    // 获取购物车数量
    public function getCount()
    {
        // 获取当前用户user_id
        try {
            $userId = $this->getUserId('users');
        } catch (\Exception $e) {
            return $this->format(0, $e->getMessage());
        }
        $cartCount = Cart::query()->where(['user_id' => $userId])
            ->groupBy('store_id')
            ->count();
        return $this->format($cartCount);
    }

    // 加入购物车
    public function addCart($cartData)
    {
        $goods_id = abs(intval($cartData['goods_id']));
        $sku_id = intval($cartData['sku_id'] ?? 0);
        $buy_num = abs(intval($cartData['buy_num'] ?? 1));
        // 判断是否非法上传
        if (empty($goods_id) || empty($buy_num)) {
            return $this->formatError(__('tip.error'));
        }
        // 获取SKU信息
        if (!empty($sku_id)) {
            $sku_info = GoodsSku::query()->find($sku_id);
            if ($sku_info->goods_id != $goods_id) {
                return $this->formatError(__('tip.error') . '2');
            }
        }
        // 获取当前用户user_id
        $userId = $this->getUserId('users');
        // 获取商品店铺信息
        $goods_info = Goods::query()->select('id', 'store_id')->with('goods_skus')->where('id', $goods_id)->first();
        if (!empty(count($goods_info->goods_skus)) && $sku_id == 0) {
            return $this->formatError(__('tip.goods.checkSku')); // 未选择SKU
        }
        // 判断购物车有没有同款商品
        $cart_info = Cart::query()->where([
            'user_id' => $userId,
            'goods_id' => $goods_id,
            'sku_id' => $sku_id,
        ])->first();
        // 如果数据库不存在
        try {
            DB::beginTransaction(); // 事务开始
            if (empty($cart_info)) {
                // 加入购物车
                $cartModel = new Cart();
                $cartModel->user_id = $userId;
                $cartModel->goods_id = $goods_id;
                $cartModel->sku_id = $sku_id;
                $cartModel->buy_num = $buy_num;
                $cartModel->store_id = $goods_info->store_id;
                $cartModel->save();
            } else {
                $cart_info->buy_num += $buy_num;
                $cart_info->save();
            }
            DB::commit(); // 事务提交
        } catch (\Exception $e) {
            DB::rollBack(); // 事务回滚
            return $this->formatError($e->getMessage());
        }
        return $this->format([], __('tip.success'));
    }

    // 修改购物车状态
    public function editCart($id, $cartData)
    {
        $is_type = intval($cartData['is_type'] ?? 0);
        $buy_num = abs(intval($cartData['buy_num'] ?? 0));
        // 获取当前用户user_id
        $userId = $this->getUserId('users');
        // 判断购物车有没有同款商品
        $cart_info = Cart::query()->where([
            'user_id' => $userId,
            'id' => $id,
        ])->first();
        if (empty($cart_info)) {
            return $this->formatError(__('tip.error') . '5'); // 获取用户失败
        }
        // 判断是否修改数量大于0
        if (!empty($buy_num) && $buy_num > 1) {
            $cart_info->buy_num = $buy_num;
            $cart_info->save();
            return $this->format([], __('tip.success'));
        }
        // 判断是增加还是减少
        if (empty($is_type)) {
            if ($cart_info->buy_num <= 1) {
                Cart::query()->where('user_id', $userId)->where('id', $id)->delete();
            } else {
                $cart_info->buy_num -= 1; // 加减购物车只能为1
                $cart_info->save();
            }
            return $this->format([], __('tip.success'));
        } else {
            $cart_info->buy_num += 1; // 加减购物车只能为1
            $cart_info->save();
            return $this->format([], __('tip.success'));
        }
    }

    public function clear($ids)
    {
        // 获取当前用户user_id
        $userId = $this->getUserId('users');
        // 判断购物车有没有同款商品
        $res = Cart::query()->where([
            'user_id' => $userId,
        ])->whereIn('id', $ids)->delete();
        return $this->format([], __('tip.success'));
    }
}