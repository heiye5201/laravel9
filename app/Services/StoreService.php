<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 20:39
 * description:
 */

namespace App\Services;

use App\Http\Resources\Home\StoreHomeCollection;
use App\Http\Resources\StoreResource;
use App\Models\Area;
use App\Models\OrderComment;
use App\Models\Store;
use App\Models\StoreClass;
use Illuminate\Support\Facades\DB;

class StoreService extends BaseService
{

    public function createStore($auth = 'users')
    {
        try {
            $userInfo = $this->getUser($auth)['data'];
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
        $userId = $userInfo['id'];
        if (!empty($userId['belong_id'])) {
            return $this->formatError(__('tip.store.subLimit'));
        }
        $store = Store::query()->where('user_id', $userId)->first();
        if ($store) {
            return $this->formatError(__('tip.store.defined'), $store);
        }
        $rs = Store::query()->create([
            'user_id' => $userId,
            'store_verify' => 1,
            'store_status' => 0,
            'store_refuse_info' => '',
            'after_sale_service' => '',
        ]);
        return $this->format($rs, __('tip.success'));
    }


    public function getStoreId($whereName = 'user_id', $auth = 'users')
    {
        try {
            $userInfo = $this->getUser($auth)['data'];
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
        $userId = empty($userInfo['belong_id']) ? $userInfo['id'] : $userInfo['belong_id'];
        $store_model = Store::query()->select('id')->where($whereName, $userId)->first();
        if (!$store_model) {
            return $this->formatError(__('tip.store.notMall') . '-2');
        }
        return $this->format($store_model->id);
    }

    public function getStoreInfo($storeId = null, $whereName = 'user_id', $auth = 'users')
    {
        if (empty($storeId)) {
            return $this->formatError(__('tip.store.notMall'));
        }
        try {
            $userInfo = $this->getUser($auth)['data'];
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
        $userId = empty($userInfo['belong_id']) ? $userInfo['id'] : $userInfo['belong_id'];
        if ($whereName == 'user_id') {
            $storeId = $userId;
        }
        $store_model = new Store();
        $store_model = $store_model->where($whereName, $storeId)->first();
        if ($whereName != 'user_id') {
            if ($store_model->user_id != $userId && $store_model->user_id != $userInfo['belong_id']) {
                return $this->formatError(__('tip.store.notMall'));
            }
        }
        if (!$store_model) throw new \Exception('store not join.');
        $store_model = new StoreResource($store_model);
        return $this->format($store_model);
    }


    // 编辑店铺数据
    public function editStore($reqData, $storeId = null, $whereName = 'user_id', $auth = 'users')
    {
        if (empty($storeId)) {
            return $this->formatError(__('tip.store.notMall'));
        }
        try {
            $userInfo = $this->getUser($auth)['data'];
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
        $userId = $whereName == 'belong_id' ? $userInfo['belong_id'] : $userInfo['id'];
        if ($whereName == 'user_id') {
            $storeId = $userId;
        }
        if ($whereName == 'belong_id') {
            $whereName = 'user_id';
        }
        $store_model = new Store();
        $storeInfo = $store_model->where($whereName, $storeId)->first();
        if ($storeInfo) {
            $store_model = $storeInfo;
        }
        if ($whereName != 'user_id' && $auth != 'admins') {
            if ($store_model->user_id != $userId && $store_model->user_id != $userInfo['belong_id']) {
                return $this->formatError(__('tip.store.notMall'));
            }
        }
        // 店铺名
        if (isset($reqData['store_name'])) {
            $store_model->store_name = $reqData['store_name'];
        }
        // 店铺LOGO
        if (isset($reqData['store_logo'])) {
            $store_model->store_logo = $reqData['store_logo'];
        }
        // 店铺门面
        if (isset($reqData['store_face_image'])) {
            $store_model->store_face_image = $reqData['store_face_image'];
        }
        // 店铺幻灯片
        if (isset($reqData['store_slide'])) {
            $store_model->store_slide = $reqData['store_slide'];
        }
        // 店铺手机幻灯片
        if (isset($reqData['store_mobile_slide'])) {
            $store_model->store_slide = $reqData['store_mobile_slide'];
        }
        // 店铺电话
        if (isset($reqData['store_mobile'])) {
            $store_model->store_mobile = $reqData['store_mobile'];
        }
        // 店铺描述
        if (isset($reqData['store_description'])) {
            $store_model->store_description = $reqData['store_description'];
        }
        // 公司名称
        if (isset($reqData['store_company_name'])) {
            $store_model->store_company_name = $reqData['store_company_name'];
        }
        // 省ID
        if (isset($reqData['province_id'])) {
            $store_model->province_id = $reqData['province_id'];
        }
        // 市ID
        if (isset($reqData['city_id'])) {
            $store_model->city_id = $reqData['city_id'];
        }
        // 区ID
        if (isset($reqData['region_id'])) {
            $store_model->region_id = $reqData['region_id'];
        }
        if (isset($reqData['area'])) {
            $areaList = Area::query()->whereIn('id', $reqData['area'])->get();
            if ($areaList) {
                $areaInfo = '';
                foreach ($areaList as $v) {
                    $areaInfo .= ' ' . $v['name'];
                }
                $store_model->area_info = ltrim($areaInfo, ' ');
            }
        }
        // 纬度
        if (isset($reqData['store_lat'])) {
            $store_model->store_lat = $reqData['store_lat'];
        }
        // 经度
        if (isset($reqData['store_lng'])) {
            $store_model->store_lng = $reqData['store_lng'];
        }
        // 详细地址
        if (isset($reqData['store_address'])) {
            $store_model->store_address = $reqData['store_address'];
        }
        // 营业执照
        if (isset($reqData['business_license'])) {
            $store_model->business_license = $reqData['business_license'];
        }
        // 营业执照号码
        if (isset($reqData['business_license_no'])) {
            $store_model->business_license_no = $reqData['business_license_no'];
        }
        // 法人
        if (isset($reqData['legal_person'])) {
            $store_model->legal_person = $reqData['legal_person'];
        }
        // 法人电话
        if (isset($reqData['store_phone'])) {
            $store_model->store_phone = $reqData['store_phone'];
        }
        // 身份证号码
        if (isset($reqData['id_card_no'])) {
            $store_model->id_card_no = $reqData['id_card_no'];
        }
        // 身份证上
        if (isset($reqData['id_card_t'])) {
            $store_model->id_card_t = $reqData['id_card_t'];
        }
        // 身份证下
        if (isset($reqData['id_card_b'])) {
            $store_model->id_card_b = $reqData['id_card_b'];
        }
        // 紧急联系人
        if (isset($reqData['emergency_contact'])) {
            $store_model->emergency_contact = $reqData['emergency_contact'];
        }
        // 紧急联系人电话
        if (isset($reqData['emergency_contact_phone'])) {
            $store_model->emergency_contact_phone = $reqData['emergency_contact_phone'];
        }
        // 售后服务
        if (isset($reqData['after_sale_service'])) {
            $store_model->after_sale_service = $reqData['after_sale_service'];
        }

        if ($auth != 'admins') {
            $store_verify = $store_model->store_verify;
            if ($store_model->store_verify == 1) {
                $store_verify = 2;
            } //待审核
            if ($store_model->store_verify == 3) {
                $store_verify = 2;
            } //审核失败重修改
            $store_model->store_verify = $store_verify;
        } else {
            // 状态
            if (isset($reqData['store_status'])) {
                $store_model->store_status = $reqData['store_status'];
            }
            // 审核状态
            if (isset($reqData['store_verify'])) {
                $store_model->store_verify = $reqData['store_verify'];
            }
        }
        try {
            $store_model->save();
            // 商家商品栏目
            if (isset($reqData['class_id']) && !empty($reqData['class_id'])) {
                $store_classes_model = new StoreClass();
                $store_classes_info = $store_classes_model->where('store_id', $store_model->id)->first();
                $class_id = [];
                foreach ($reqData['class_id'] as $k => $v) {
                    if (count($v) > 3) {
                        $class_id[] = $v;
                    }
                }
                $data = [
                    'store_id' => $store_model->id,
                    'class_id' => json_encode($reqData['class_id'] ?? []),
                    'class_name' => '',
                ];
                if (empty($store_classes_info)) {
                    $store_classes_model->insert($data);
                } else {
                    $store_classes_model->where('store_id', $store_model->id)->update($data);
                }
            }
        } catch (\Exception $e) {
            return $this->formatError(__('tip.error').$e->getMessage());
        }
        return $this->format([], __('tip.success'));
    }

    // 获取店铺信息和评分信息
    public function getStoreInfoAndRate($storeId)
    {
        $storeInfo = Store::query()->find($storeId)->toArray();
        $info = OrderComment::query()->where('store_id', $storeId)->first([
            DB::raw('avg(score) as scoreAll'),
            DB::raw('avg(agree) as agreeAll'),
            DB::raw('avg(service) as serviceAll'),
            DB::raw('avg(speed) as speedAll'),
        ])->toArray();
        foreach ($info as $k => $v) {
            $info[$k] = intval($v) == 0 ? 5 : intval($v);
        }
        $storeInfo['rate'] = $info;
        $storeInfo['store_logo'] = getUrlByPath($storeInfo['store_logo']);
        unset($storeInfo['id_card_b'], $storeInfo['id_card_t'], $storeInfo['id_card_no'], $storeInfo['store_money'], $storeInfo['legal_person'], $storeInfo['emergency_contact_phone'], $storeInfo['emergency_contact'], $storeInfo['business_license']);
        return $this->format($storeInfo);
    }

    public $storeStatus = ['store_status' => 1, 'store_verify' => 4]; // 正常店铺

    // 无权限获取店铺
    public function stores($reqData)
    {
        $params = $reqData['params'] ?? '';
        $lat = $reqData['lat'] ?? '39.56';
        $lng = $reqData['lng'] ?? '116.20'; // 默认北京的经纬度
        $distance = "ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(('$lat' * PI() / 180 - store_lat * PI() / 180) / 2),2) + COS(40.0497810000 * PI() / 180) * COS(store_lat * PI() / 180) * POW(SIN(('$lng' * PI() / 180 - store_lng * PI() / 180) / 2),2))) * 1000 )  AS distance ";
        $storeModel = Store::query()->select(DB::raw('*,' . $distance))->withCount(['comments', 'comments as good_comment' => function ($q) {
            $q->whereRaw('(score+agree+speed+service)>=15');
        }])->where($this->storeStatus);
        try {
            if (!empty($params)) {
                $params_array = json_decode(base64_decode($params), true);
                // 排序
                if (isset($params_array['sort_type']) && !empty($params_array['sort_type'])) {
                    $storeModel = $storeModel->orderBy($params_array['sort_type'], $params_array['sort_order']);
                } else {
                    $storeModel = $storeModel->orderBy('distance', 'desc')->orderBy('id', 'desc');
                }
                // 关键词
                if (isset($params_array['keywords']) && !empty($params_array['keywords'])) {
                    $params_array['keywords'] = urldecode($params_array['keywords']);
                    $storeModel = $storeModel->where('store_name', 'like', '%' . $params_array['keywords'] . '%');
                }
            }
            $list = $storeModel->paginate($reqData['per_page'] ?? 30);
            return $this->format(new StoreHomeCollection($list));
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
    }
}