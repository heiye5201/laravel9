<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/17 20:44
 * description:
 */

namespace App\Services;

use App\Models\Address;
use App\Models\Area;

class AddressService extends BaseService
{

    public $belongName = 'user_id';

    public function add($addressData)
    {
        $area = Area::query()->select('name')->whereIn('id', $addressData['area'])->get();
        $areaInfo = '';
        if (!empty($area)) {
            foreach ($area as $v) {
                $areaInfo .= $v['name'].' ';
            }
        }
        $areaInfo = rtrim($areaInfo, ' ');
        $userId = $this->getUserId('users');
        $data = [
            'user_id'  =>  $userId,
            'receive_name'  => $addressData['receive_name'] ?? '',
            'receive_tel'  =>  $addressData['receive_tel'] ?? '',
            'province_id'  =>  $addressData['area'][0] ?? 0,
            'city_id'  =>  $addressData['area'][1] ?? 0,
            'region_id'  => $addressData['area'][2] ?? 0,
            'address'  => $addressData['address'] ?? '',
            'area_info' =>  $areaInfo,
            'is_default'  => $addressData['is_default'] ?1:0,
        ];
        try {
            if ($data['is_default']) {
                Address::query()->where('user_id', $userId)->update(['is_default'=>0]);
            }
            $rs = Address::query()->create($data);
            return $this->format($rs);
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
    }

    public function edit($id, $addressData)
    {
        $area = Area::query()->select('name')->whereIn('id', $addressData['area'])->get();
        $areaInfo = '';
        if (!empty($area)) {
            foreach ($area as $v) {
                $areaInfo .= $v['name'].' ';
            }
        }
        $areaInfo = rtrim($areaInfo, ' ');
        $userId = $this->getUserId('users');
        $data = [
            'receive_name'  => $addressData['receive_name'] ?? '',
            'receive_tel'  =>  $addressData['receive_tel'] ?? '',
            'province_id'  =>  $addressData['area'][0] ?? 0,
            'city_id'  =>  $addressData['area'][1] ?? 0,
            'region_id'  => $addressData['area'][2] ?? 0,
            'address'  => $addressData['address'] ?? '',
            'area_info' =>  $areaInfo,
            'is_default'  => $addressData['is_default'] ?1:0,
        ];
        try {
            if ($data['is_default']) {
                Address::query()->where('user_id', $userId)->update(['is_default'=>0]);
            }
            $rs = Address::query()->where('id', $id)->where($this->belongName, $userId)->update($data);
            return $this->format($rs);
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
    }

    public function setDefault($id)
    {
        $userId = $this->getUserId('users');
        try {
            Address::query()->where($this->belongName, $userId)->update(['is_default'=>0]);
            $rs = Address::query()->where('id', $id)->where($this->belongName, $userId)->update(['is_default'=>1]);
            return $this->format($rs);
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
    }

    // 获取默认地址
    public function getDefault()
    {
        // 获取当前用户user_id
        $userId = $this->getUserId('users');
        $address = Address::query()->where('user_id', $userId)->where('is_default', 1)->first();
        if (empty($address)) {
            $address =  Address::query()->where('user_id', $userId)->first();
        }
        return $this->format($address, __('tip.success'));
    }



    public function addNew($form)
    {
        $userId = $this->getUserId('users');
        $data = [
            'user_id'  =>  $userId,
            'receive_name'  =>  $form['receive_name']??'',
            'receive_tel'  =>  $form['receive_tel']??'',
            'address'  =>  $form['address']??'',
        ];
        $region = $form['region'];
        $province = $region[0];
        $city = $region[1];
        $area = $region[2];
        $data['province_id'] = $province['value'];
        $data['city_id'] = $city['value'];
        $data['region_id'] = $area['value'];
        $data['area_info'] = $province['label']." ".$city['label']." ".$area['label'];
        try {
            $rs = Address::query()->create($data);
            return $this->format($rs);
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
    }

    public function editNew($id,$form)
    {
        $userId = $this->getUserId('users');
        $data = [
            'receive_name'  =>  $form['receive_name']??'',
            'receive_tel'  =>  $form['receive_tel']??'',
            'address'  =>  $form['address']??'',
        ];
        $region = $form['region'];
        $province = $region[0];
        $city = $region[1];
        $area = $region[2];
        $data['province_id'] = $province['value'];
        $data['city_id'] = $city['value'];
        $data['region_id'] = $area['value'];
        $data['area_info'] = $province['label']." ".$city['label']." ".$area['label'];
        $rs = Address::query()->where('id', $id)->where($this->belongName, $userId)->update($data);
        return $this->format($rs);
    }


    public function remove($id)
    {
        $userId = $this->getUserId('users');
        $rs = Address::query()->where('id', $id)->where($this->belongName, $userId)->delete();
        return $this->format($rs);
    }
}
