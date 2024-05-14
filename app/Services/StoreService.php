<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 20:39
 * description:
 */

namespace App\Services;

use App\Http\Resources\Seller\StoreResource;
use App\Models\Area;
use App\Models\Store;
use App\Models\StoreClass;

class StoreService extends BaseService
{

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
    public function editStore($storeId = null, $whereName = 'user_id', $auth = 'users')
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
        $store_model = $store_model->where($whereName, $storeId)->first();
        if ($whereName != 'user_id' && $auth != 'admins') {
            if ($store_model->user_id != $userId && $store_model->user_id != $userInfo['belong_id']) {
                return $this->formatError(__('tip.store.notMall'));
            }
        }
        // 店铺名
        if (isset(request()->store_name)) {
            $store_model->store_name = request()->store_name;
        }
        // 店铺LOGO
        if (isset(request()->store_logo)) {
            $store_model->store_logo = request()->store_logo;
        }
        // 店铺门面
        if (isset(request()->store_face_image)) {
            $store_model->store_face_image = request()->store_face_image;
        }
        // 店铺幻灯片
        if (isset(request()->store_slide)) {
            $store_model->store_slide = request()->store_slide;
        }
        // 店铺手机幻灯片
        if (isset(request()->store_mobile_slide)) {
            $store_model->store_slide = request()->store_mobile_slide;
        }
        // 店铺电话
        if (isset(request()->store_mobile)) {
            $store_model->store_mobile = request()->store_mobile;
        }
        // 店铺描述
        if (isset(request()->store_description)) {
            $store_model->store_description = request()->store_description;
        }
        // 公司名称
        if (isset(request()->store_company_name)) {
            $store_model->store_company_name = request()->store_company_name;
        }
        // 省ID
        if (isset(request()->province_id)) {
            $store_model->province_id = request()->province_id;
        }
        // 市ID
        if (isset(request()->city_id)) {
            $store_model->city_id = request()->city_id;
        }
        // 区ID
        if (isset(request()->region_id)) {
            $store_model->region_id = request()->region_id;
        }
        if (isset(request()->area)) {
            $areaList = Area::query()->whereIn('id', request()->area)->get();
            if ($areaList) {
                $areaInfo = '';
                foreach ($areaList as $v) {
                    $areaInfo .= ' ' . $v['name'];
                }
                $store_model->area_info =  ltrim($areaInfo, ' ');
            }
        }
        // 纬度
        if (isset(request()->store_lat)) {
            $store_model->store_lat = request()->store_lat;
        }
        // 经度
        if (isset(request()->store_lng)) {
            $store_model->store_lng = request()->store_lng;
        }
        // 详细地址
        if (isset(request()->store_address)) {
            $store_model->store_address = request()->store_address;
        }
        // 营业执照
        if (isset(request()->business_license)) {
            $store_model->business_license = request()->business_license;
        }
        // 营业执照号码
        if (isset(request()->business_license_no)) {
            $store_model->business_license_no = request()->business_license_no;
        }
        // 法人
        if (isset(request()->legal_person)) {
            $store_model->legal_person = request()->legal_person;
        }
        // 法人电话
        if (isset(request()->store_phone)) {
            $store_model->store_phone = request()->store_phone;
        }
        // 身份证号码
        if (isset(request()->id_card_no)) {
            $store_model->id_card_no = request()->id_card_no;
        }
        // 身份证上
        if (isset(request()->id_card_t)) {
            $store_model->id_card_t = request()->id_card_t;
        }
        // 身份证下
        if (isset(request()->id_card_b)) {
            $store_model->id_card_b = request()->id_card_b;
        }
        // 紧急联系人
        if (isset(request()->emergency_contact)) {
            $store_model->emergency_contact = request()->emergency_contact;
        }
        // 紧急联系人电话
        if (isset(request()->emergency_contact_phone)) {
            $store_model->emergency_contact_phone = request()->emergency_contact_phone;
        }
        // 售后服务
        if (isset(request()->after_sale_service)) {
            $store_model->after_sale_service = request()->after_sale_service;
        }
        // 商家商品栏目
        if (isset(request()->class_id) && !empty(request()->class_id)) {
            $store_classes_model = new StoreClass();
            $store_classes_info = $store_classes_model->where('store_id', $store_model->id)->first();
            $class_id = [];
            foreach (request()->class_id as $k => $v) {
                if (count($v) > 3) {
                    $class_id[] = $v;
                }
            }
            $data = [
                'store_id' => $store_model->id,
                'class_id' => json_encode(request('class_id', [])),
                'class_name' => '',
            ];
            if (empty($store_classes_info)) {
                $store_classes_model->insert($data);
            } else {
                $store_classes_model->where('store_id', $store_model->id)->update($data);
            }
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
            if (isset(request()->store_status)) {
                $store_model->store_status = request()->store_status;
            }
            // 审核状态
            if (isset(request()->store_verify)) {
                $store_model->store_verify = request()->store_verify;
            }
        }
        try {
            $store_model->save();
        } catch (\Exception $e) {
            return $this->formatError(__('tip.error'));
        }
        return $this->format([], __('tip.success'));
    }
}