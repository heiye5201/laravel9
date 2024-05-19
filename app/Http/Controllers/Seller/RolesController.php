<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\UserRoleQuery;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    protected $auth = 'users';

    public function index(Request $request, UserRoleQuery $query)
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

    // 添加角色
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $model = UserRole::query()->where('belong_id', $this->getBelongId())->create(['name' => $request->name ?? '', 'belong_id' => $this->getUserId()]);
            $model->menus()->sync($request->menu_id ?? []);
            $model->permissions()->sync($request->permission_id ?? []);
            DB::commit();
            return $this->success([], __('tip.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    // 显示
    public function show($id)
    {
        $rs = UserRole::query()->where('belong_id', $this->getBelongId())->with(['menus', 'permissions'])->find($id);
        return $this->success($rs, __('tip.success'));
    }

    // 修改
    public function update(Request $request, $id)
    {
        try {
            $model = UserRole::query()->find($id);
            $model->name = $request->name;
            $model->belong_id = $this->getBelongId($this->auth);
            $model->save();
            $model->menus()->sync($request->menu_id ?? []);
            $model->permissions()->sync($request->permission_id ?? []);
            DB::commit();
            return $this->success([], __('tip.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    // 删除
    public function destroy($id)
    {
        $idArray = array_filter(explode(',', $id), function ($item) {
            return (is_numeric($item)); // 超级管理员也不允许删除
        });
        foreach ($idArray as $v) {
            $model = UserRole::query()->find($v);
            $model->menus()->detach();
            $model->permissions()->detach();
            $model->refresh();
        }

        $model->whereIn('id', $idArray)->where('belong_id', $this->getBelongId($this->auth))->delete();
        return $this->success([], __('tip.success'));
    }
}
