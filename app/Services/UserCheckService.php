<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/17 20:55
 * description:
 */
namespace App\Services;

use App\Models\UserCheck;

class UserCheckService extends BaseService
{
    public function check()
    {
        $userId = $this->getUserId('users');
        $info = UserCheck::query()->where('user_id', $userId)->first();
        return $this->format($info);
    }

    public function edit($data)
    {
        $userId = $this->getUserId('users');
        $model = new UserCheck();
        $info = $model->where('user_id', $userId)->exists();
        $data['user_id'] = $userId;
        if (!$info) {
            return $this->format($model->create($data));
        }
        return $this->format($model->where('user_id', $userId)->update($data));
    }
}