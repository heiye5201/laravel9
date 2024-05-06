<?php

namespace App\Services;

use App\Models\AdminRole;
use App\Models\Admins;
use App\Traits\ResourceTrait;

class BaseService
{
    use ResourceTrait;

    public function getUser($auth = 'admins')
    {
        try {
            return $this->format(auth($auth)->user());
        } catch (\Exception $e) {
            throw new \Exception(__('tip.userThr'));
        }
    }


    public function getSuper($auth = 'admins')
    {
        try {
            $info = auth($auth)->user();
            if ($auth != 'admins') {
                return empty($info['belong_id']);
            }
            return !empty($info['is_super']);
        } catch (\Exception $th) {
            throw new \Exception(__('tip.userThr'));
        }
    }


    // 获取当前用户的角色信息
    public function getRoles($with)
    {
        try {
            $info = auth('admins')->user();
            $user = Admins::query()->with('roles')->find($info['id']);
            $roleId = collect($user['roles'] ?? [])->pluck('id')->toArray();
            $roles = AdminRole::query()->with($with)
                ->whereIn('id', empty($roleId) ? [0] : $roleId)->get()->toArray();
            // 去重
            $rolesData = collect([ 'menus' => [], 'permissions' => [], 'roleName' => []]);
            collect($roles)->each(function ($v) use ($rolesData) {
                $rolesData['menus'] = array_merge($rolesData['menus'], $v['menus'] ?? []);
                $rolesData['permissions'] = array_merge($rolesData['permissions'], $v['permissions'] ?? []);
                $rolesData['roleName'][] = $v['name'];
            });
            $rolesData['menus'] = collect($rolesData['menus'])
                ->map(function ($menu) {
                    return json_encode($menu);
                })->unique()
                ->map(function ($menu) {
                    return json_decode($menu, true);
                })->toArray();
            $rolesData['permissions'] = collect($rolesData['permissions'])
                ->map(function ($permission) {
                    return json_encode($permission);
                })->unique()
                ->map(function ($permission) {
                    return json_decode($permission, true);
                })->toArray();
            return ['roleId' => $roleId, 'roles' => $rolesData];
        } catch (\Exception $th) {
            throw new \Exception(__('tip.userThr') . $th->getMessage());
        }
    }
}