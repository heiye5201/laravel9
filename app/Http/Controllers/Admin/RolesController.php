<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\Admin\AdminQuery;
use App\Http\Queries\Admin\AdminRoleQuery;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    protected $belongName = 'belong_id';

    public function index(Request $request, AdminRoleQuery $query)
    {
        $isAll = $request->input('isAll', false);
        $query = $query->orderBy('id', 'desc');
        if ($isAll) {
            $data = $query->get();
        } else {
            $data = $query->paginate(intval($request->input('page_size', 25)));
        }
        return $this->success($data);
    }

    // 添加角色
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $model = AdminRole::query()->where($this->belongName, $this->getBelongId())
                ->create(['name' => $request->name ?? '', $this->belongName => $this->getUserId()]);
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
        $rs = AdminRole::query()->where($this->belongName, $this->getBelongId())->with(['menus', 'permissions'])->find($id);
        return $this->success($rs, __('tip.success'));
    }

    // 修改
    public function update(Request $request, $id)
    {
        try {
            $belongName = $this->belongName;
            $model = AdminRole::query()->find($id);
            $model->name = $request->name;
            $model->$belongName = $this->getBelongId($this->auth);
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
            return (is_numeric($item) && $item != 1); // 超级管理员也不允许删除
        });
        foreach ($idArray as $v) {
            $model = AdminRole::query()->find($v);
            $model->menus()->detach();
            $model->permissions()->detach();
            $model->refresh();
        }
        $model->whereIn('id', $idArray)->where($this->belongName, $this->getBelongId($this->auth))->delete();
        return $this->success([], __('tip.success'));
    }
}
