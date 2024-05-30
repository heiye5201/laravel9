<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/17 21:18
 * description:
 */
namespace App\Services;

use App\Models\Order;
use App\Models\Refund;

class RefundService extends BaseService
{
    public function add($reqData)
    {
        $userId = $this->getUserId('users');
        $refund_model = new Refund();
        $order_id = $reqData['order_id']??0;
        $refund_type = $reqData['refund_type']??0;
        $refund_remark = $reqData['refund_remark']??'';
        $images = $reqData['images']??'';
        $order_info = Order::query()->where('user_id', $userId)->where('id', $order_id)->first();
        if (!$order_info) {
            return $this->formatError(__('tip.error'));
        }
        if ($order_info->pay_time->lt(now()->subDays(7))) {
            return $this->formatError('over 7 days');
        }
        if ($refund_model->where('user_id', $userId)->where('refund_verify', 0)->where('order_id', $order_id)->exists()) {
            return $this->formatError('refund handled');
        }
        // 如果在待发货时 就申请售后，应该直接退款，这里后面再处理
        $refund_model->user_id = $userId;
        $refund_model->order_id = $order_id;
        $refund_model->store_id = $order_info->store_id;
        $refund_model->refund_type = $refund_type;
        $refund_model->refund_remark = $refund_remark;
        $refund_model->images = $images;
        $refund_model->save();
        // 修改订单状态
        $order_info->order_status = 5;
        $order_info->refund_status = $refund_type;
        $rs = $order_info->save();
        return $this->format($rs, __('tip.success'));
    }

    // 修改
    public function edit($id, $reqData, $auth='user')
    {
        $refund_model = new Refund();
        if ($auth == 'seller') {
            $store_id = app(StoreService::class)->getStoreId()['data'];
            $refund_model = $refund_model->where('store_id', $store_id);
        }
        if ($auth== 'user') {
            $userId = $this->getUserId('users');
            $refund_model = $refund_model->where('user_id', $userId);
        }
        $refund_info = $refund_model->where('order_id', $id)->first();
        if (!$refund_info) {
            return $this->formatError(__('tip.error'));
        }
        if (isset($reqData['refund_verify']) && $auth =='seller') {
            $refund_verify = $reqData['refund_verify'];
            if ($refund_info->refund_verify!=0) {
                return $this->formatError(__('tip.error').'- rep');
            }
            // 拒绝还是同意
            if ($refund_verify == 1) {
                // 如果是退款
                if ($refund_info->refund_type == 0) {
                    // 直接进行用户资金操作
                    $order_info = Order::query()->where('id', $id)->first();
                    app(MoneyLogService::class)->edit([
                        'name'=>'售后退款',
                        'money'=>$order_info->total_price,
                        'user_id'=>$refund_info->user_id,
                        'info'=>$order_info['order_no'],
                    ]);

                    // 修改订单状态
                    $order_info = Order::query()->where('id', $id)->where('store_id', $store_id)->first();
                    $order_info->order_status = 6;
                    $order_info->refund_status = 2;
                    $order_info->save();
                    $refund_info->refund_step = 3;
                }
                $refund_info->refund_verify = $refund_verify;
                $rs = $refund_info->save();
            } else {
                $refund_info->refund_verify = 2;
                $refund_info->refuse_remark = $reqData['refuse_remark']??'暂无任何原因';
                // 修改订单状态
                $order_model = new Order();
                $order_info = $order_model->where('id', $id)->where('store_id', $store_id)->first();
                $order_info->order_status = 6;
                $order_info->refund_status = 2;
                $order_info->save();
                $rs = $refund_info->save();
            }
            return $this->format($rs, __('tip.success'));
        }
        if (isset($reqData['delivery_no']) && !empty($reqData['delivery_no']) && $auth == 'user' && $refund_info->refund_verify==1) {
            $refund_info->delivery_no = $reqData['delivery_no']??'';
            $refund_info->delivery_code = $reqData['delivery_code']??'';
            $refund_info->refund_step = 1;
            if ($refund_info->re_delivery_no != '') {
                $refund_info->refund_step = 2;
            }
        }
        if (isset($reqData['re_delivery_no']) && !empty($reqData['re_delivery_no']) && $auth == 'seller' && $refund_info->refund_step<=1) {
            $refund_info->re_delivery_no = $reqData['re_delivery_no']??'';
            $refund_info->re_delivery_code = $reqData['re_delivery_code']??'';
            if ($refund_info->refund_step == 1) {
                $refund_info->refund_step = 2;
            }
        }
        if (isset($reqData['refund_step']) && !empty($reqData['refund_step']) && $auth == 'user' && $refund_info->refund_verify==1 && $refund_info->refund_step==2) {
            $refund_info->refund_step = 3;
            // 修改订单状态
            $order_model = new Order();
            $order_info = $order_model->where('id', $id)->where('user_id', $refund_info->user_id)->first();
            $order_info->order_status = 6;
            $order_info->refund_status = 2;
            $order_info->save();
        }
        $rs = $refund_info->save();
        return $this->format($rs, __('tip.success'));
    }

    // 获取售后信息
    public function getRefundByOrderId($order_id, $auth = 'user')
    {
        $refund_model = new Refund();
        if ($auth == 'user') {
            $userId = $this->getUserId('users');
            $refund_model = $refund_model->where('user_id', $userId);
        }
        if ($auth == 'seller') {
            $store_id = app(StoreService::class)->getStoreId()['data'];
            $refund_model = $refund_model->where('store_id', $store_id);
        }
        $refund_info = $refund_model->where('order_id', $order_id)->first();
        if (!$refund_info) {
            return $this->formatError(__('tip.error'));
        }
        return $this->format($refund_info);
    }
}