<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/17 21:02
 * description:
 */
namespace App\Services;

use App\Models\Cash;
use App\Models\UserCheck;
use Illuminate\Support\Facades\DB;

class CashService extends BaseService
{
    public function add($cashData, $whereName = 'user_id')
    {
        $data = [];
        $money = floatval(abs($cashData['money']));
        if ($whereName == 'user_id') {
            $info = $this->getUser('users')['data'];
            $id = $info['id'];
            if ($money > $info['money']) {
                return $this->formatError(__('tip.cash.moneyNotEnough'));
            }
            $data['user_id'] = $id;
        } else {
            $store = app(StoreService::class)->getStoreInfo()['data'];
            $id = $store['id'];
            if ($money > $store['store_money']) {
                return $this->formatError(__('tip.cash.moneyNotEnough'));
            }
            $data['store_id'] = $id;
        }
        $userCheck = UserCheck::query()->where('user_id', $id)->first();
        if (!$userCheck) {
            return $this->formatError(__('tip.cash.notCheck'));
        }
        if ($money <= 0) {
            return $this->formatError(__('tip.cash.moneyZero'));
        }
        $storeConfig = app(ConfigsService::class)->getFormatConfig('store');
        $cashRate = !isset($storeConfig['cash']) && empty($storeConfig['cash']) ? 0 : round(floatval($storeConfig['cash']) / 100, 2);
        $data['name'] = $userCheck->name;
        $data['card_no'] = $userCheck->bank_no;
        $data['bank_name'] = $userCheck->bank_name;
        $data['commission'] = round($money * $cashRate, 2);
        $data['money'] = $money - $data['commission'];
        $data['remark'] = $cashData['remark'] ?? '';
        $data['refuse_info'] = '';
        try {
            DB::beginTransaction();
            Cash::query()->create($data);
            app(MoneyLogService::class)->edit(['money' => $money, 'is_type' => 1, 'name' => '资金提现']);
            app(MoneyLogService::class)->edit(['money' => -$money, 'is_type' => 0, 'name' => '资金提现']);
            DB::commit();
            return $this->format();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->formatError($e->getMessage());
        }
    }

    // 编辑提现状态
    public function edit($id, $cashData)
    {
        $model = Cash::query()->where('id', $id)->first();
        if (!empty($cashData['cash_status'] ?? 0)) $model->cash_status = abs(intval($cashData['cash_status']));
        $model->refuse_info = $cashData['refuse_info'] ?? '';
        $model->remark = $cashData['remark'] ?? '';
        $model->save();
        switch ($model->cash_status) {
            case 1:
                if ($model->user_id > 0) app(MoneyLogService::class)->edit(['money' => -$model->money, 'user_id' => $model->user_id, 'is_type' => 1, 'name' => '提现成功']);
                if ($model->store_id > 0) app(MoneyLogService::class)->edit(['money' => -$model->money, 'user_id' => $model->store_id, 'is_type' => 1, 'is_belong' => 1, 'name' => '提现成功']);
                break;
            case 2:
                if ($model->user_id > 0) app(MoneyLogService::class)->edit(['money' => $model->money, 'user_id' => $model->user_id, 'is_type' => 0, 'name' => '拒绝提现']);
                if ($model->store_id > 0) app(MoneyLogService::class)->edit(['money' => $model->money, 'user_id' => $model->store_id, 'is_type' => 0, 'is_belong' => 1, 'name' => '拒绝提现']);
                break;
        }
        return $this->format();
    }
}