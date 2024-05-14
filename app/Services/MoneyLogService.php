<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/14 22:28
 * description:
 */

namespace App\Services;

use App\Models\MoneyLog;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MoneyLogService extends BaseService
{
    /**
     * 修改用户金额 增加日志 function
     *
     * @param [type] $params money|name|is_type|is_belong|info 金额
     * @param [type] $name 名称  订单支付|后台操作
     * @param integer $type 类型 0 金额 1冻结资金 2积分
     * @return void
     * @Description
     * @author hg <www.RainNight.com>
     */
    public function edit($params = [])
    {
        $data = [
            'money' => 0,
            'is_type' => 0,
            'user_id' => 0,
            'name' => __('tip.payment.orderPay'),
            'info' => '',
            'is_belong' => 0,
            'isLog' => false,
        ];
        $data = array_merge($data, $params);
        $userId = ($data['user_id'] == 0) ? $this->getUserId('users') : $data['user_id'];
        try {
            DB::beginTransaction();
            $ml_model = new MoneyLog();
            $ml_model->user_id = $userId;
            $ml_model->money = $data['money'];
            $ml_model->is_type = $data['is_type'];
            $ml_model->name = $data['name'];
            $ml_model->is_belong = $data['is_belong'];
            $ml_model->info = $data['info'];
            // 如果只要日志
            if ($data['isLog']) {
                $ml_model->save();
                DB::commit();
                return $this->format([]);
            }
            if (!empty($data['is_belong'])) {
                if ($data['user_id'] == 0) {
                    $store = app(StoreService::class)->getStoreInfo(true)['data'];
                } else {
                    $store = ['id' => $data['user_id']];
                }
                // 店铺的使用店铺ID
                $ml_model->user_id = $store['id'];

                if ($model = Store::query()->lockForUpdate()->where('id', $store['id'])->first()) {
                    switch ($data['is_type']) {
                        case 0:
                            $model->store_money += floatval($data['money']);
                            break;
                        case 1:
                            $model->store_frozen_money += floatval($data['money']);
                            break;
                    }
                    $model->save();
                } else {
                    throw new \Exception(__('tip.error') . ' - money log');
                }
            } else {
                if ($model = User::query()->lockForUpdate()->find($userId)) {
                    switch ($data['is_type']) {
                        case 0:
                            $model->money += $data['money'];
                            break;
                        case 1:
                            $model->frozen_money += $data['money'];
                            break;
                        case 2:
                            $model->integral += $data['money'];
                            break;
                    }
                    $model->save();
                } else {
                    throw new \Exception(__('tip.error') . ' - money log');
                }
            }
            $ml_model->save();
            DB::commit();
            return $this->format([]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->formatError($e->getMessage());
        }
    }

    // 获取日志列表
    public function getMoneyLog()
    {
        $auth = request()->auth ?? 'users';
        $money_log_model = new MoneyLog();
        if ($auth == 'users') {
            $money_log_model = $money_log_model->where('user_id', $this->getUserId($auth))->where('is_belong', 0);
        }
        if ($auth == 'seller') {
            $store = app(StoreService::class)->getStoreInfo();
            $money_log_model = $money_log_model->where('user_id', $store['user_id'])->where('is_belong', 1);
        }
        if (isset(request()->is_type)) {
            $money_log_model = $money_log_model->where('is_type', request()->is_type ?? 0);
        }
        if (isset(request()->type) && request()->type == 'recharge') {
            $money_log_model = $money_log_model->where('money', '>', 0);
        }
        $list = $money_log_model->orderBy('id', 'desc')->paginate(request()->per_page ?? 30);
        return $this->format($list);
    }


    // 获取日志列表
    public function getRecharge()
    {
        $auth = request()->auth ?? 'users';
        $money_log_model = new MoneyLog();
        if ($auth == 'users') {
            $money_log_model = $money_log_model->where('user_id', $this->getUserId($auth))->where('is_belong', 0);
        }
        if ($auth == 'seller') {
            $store = app(StoreService::class)->getStoreInfo();
            $money_log_model = $money_log_model->where('user_id', $store['user_id'])->where('is_belong', 1);
        }
        if (isset(request()->is_type)) {
            $money_log_model = $money_log_model->where('is_type', request()->is_type ?? 0);
        }
        $money_log_model = $money_log_model->where('money', '>', 0);
        $list = $money_log_model->orderBy('id', 'desc')->paginate(request()->per_page ?? 30);
        return $this->format($list);
    }

}