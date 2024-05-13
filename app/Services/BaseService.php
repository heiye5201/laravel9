<?php

namespace App\Services;

use App\Models\AdminRole;
use App\Models\Admins;
use App\Traits\ResourceTrait;
use Illuminate\Support\Facades\Route;

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


    public function getBelongId($auth = 'admins')
    {
        try {
            $info = auth($auth)->user();
            return empty($info['belong_id']) ? $info['id'] : $info['belong_id'];
        } catch (\Exception $th) {
            throw new \Exception(__('tip.userThr'));
        }
    }

    public function getUserId($auth = 'admins')
    {
        try {
            $id = auth($auth)->id();
            if ($id === null) {
                throw new \Exception(__('tip.userThr'));
            }
            return $id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    public function getRoutes($auth = "")
    {
        if (empty($auth)) {
            $uris = explode('/', request()->route()->uri);
            $auth = $uris[0] . '/' . $uris[1];
        }
        $routeList = Route::getRoutes();
        $routeApis = [];
        foreach ($routeList as $v) {
            if ($v->action['prefix'] != $auth || !isset($v->action['as'])) {
                continue;
            }
            $items = [];
            $items['as'] = $v->action['as'];
            $items['controller'] = $v->action['controller'];
            $items['uri'] = $v->uri;
            $asArr = explode('.', $items['as']);
            $InterfaceName = $asArr[0] . '-';
            switch ($asArr[1]) {
                case 'index':
                    $InterfaceName = $asArr[0] . '-' . __('tip.permission.index');
                    break;
                case 'store':
                    $InterfaceName = $asArr[0] . '-' . __('tip.permission.store');
                    break;
                case 'show':
                    $InterfaceName = $asArr[0] . '-' . __('tip.permission.view');
                    break;
                case 'update':
                    $InterfaceName = $asArr[0] . '-' . __('tip.permission.update');
                    break;
                case 'destroy':
                    $InterfaceName = $asArr[0] . '-' . __('tip.permission.destroy');
                    break;
            }
            $items['Interface_name'] = $InterfaceName;
            $routeApis[] = $items['as'];
        }
        return $this->format($routeApis);
    }
}