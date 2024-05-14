<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\CashQuery;
use App\Models\Cash;
use App\Services\ConfigsService;
use App\Services\MoneyLogService;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashesController extends Controller
{

    public function index(Request $request, CashQuery $query)
    {
        $isAll = $request->input('isAll', false);
        if ($isAll) {
            $data = $query->orderBy('id', 'desc')
                ->get();
        } else {
            $data = $query->orderBy('id', 'desc')
                ->paginate(intval($request->input('page_size', 25)));
        }
        return $this->success($data);
    }

    public function store(Request $request)
    {
        $money = round(abs($request->money), 2);
        $storeInfo = app(StoreService::class)->getStoreInfo(true)['data'];
        if ($money == 0) {
            return $this->error(__('tip.cash.moneyZero'));
        }
        if ($storeInfo['store_money'] < $money) {
            return $this->error(__('tip.cash.moneyNotEnough'));
        }
        // 获取店铺提现手续费
        $storeConfig = app(ConfigsService::class)->getFormatConfig('store');
        $cashRate = !isset($storeConfig['cash']) && empty($storeConfig['cash']) ? 0 : round(floatval($storeConfig['cash']) / 100, 2);
        $model = new Cash();
        $model->name = $request->name ?? '';
        $model->bank_name = $request->bank_name ?? '';
        $model->card_no = $request->card_no ?? '';
        $model->store_id = $storeInfo['id'];
        $model->commission = round($money * $cashRate, 2);
        $model->money = $money - $model->commission;
        $model->remark = $request->remark ?? '';
        try {
            DB::beginTransaction();
            $model->save();
            $rs = app(MoneyLogService::class)->edit([
                'name' => '商家提现',
                'money' => -$money,
                'is_type' => 0,
                'is_belong' => 1,
            ]);
            if (!$rs['status']) {
                throw new \Exception($rs['msg']);
            }
            $rs = app(MoneyLogService::class)->edit([
                'name' => '商家提现',
                'money' => $money,
                'is_type' => 1,
                'is_belong' => 1,
            ]);
            if (!$rs['status']) {
                throw new \Exception($rs['msg']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
        return $this->success();
    }


    public function destroy($id)
    {
        $tableModel = new Cash();
        if (!empty($where)) {
            $tableModel = $tableModel->where($where);
        }
        $idArray = array_filter(explode(',', $id), function ($item) {
            return is_numeric($item);
        });
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $tableModel = $tableModel->where('store_id', $storeId)->whereIn('id', $idArray)->get();
        foreach ($tableModel as $v) {
            app(MoneyLogService::class)->edit([
                'name' => '取消提现',
                'money' => $v['money'],
                'is_type' => 0,
                'is_belong' => 1,
            ]);
            app(MoneyLogService::class)->edit([
                'name' => '取消提现',
                'money' => -$v['money'],
                'is_type' => 1,
                'is_belong' => 1,
            ]);
        }
        $rs = Cash::query()->where('store_id', $storeId)->whereIn('id', $idArray)->delete();
        if (!$rs) {
            return $this->formatError('find data error.');
        }
        return $this->format($rs);
    }


    public function show($id)
    {
        $data = Cash::query()->find($id)->toArray();
        return $this->success($data);
    }
}
