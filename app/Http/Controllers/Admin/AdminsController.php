<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\Admin\AdminQuery;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    protected $belongName = 'belong_id';

    public function index(Request $request, AdminQuery $query)
    {
        $data = $query->where($this->belongName, '>', 0)->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }


    // 添加
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $model = Admins::query()
                ->create([
                    'username' => $request->username ?? '',
                    'password' => Hash::make($request->password ?? '123456'),
                    'nickname' => $request->username ?? 'Mysterious',
                    'avatar' => $request->avatar ?? '',
                    $this->belongName => $this->getBelongId()
                ]);
            $model->roles()->sync($request->role_id ?? []);
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
        $rs = Admins::query()->where($this->belongName, $this->getBelongId())->with(['roles'])->find($id);
        $role_id = [];
        $role_name = [];
        if (!empty($rs['roles'])) {
            foreach ($rs['roles'] as $v) {
                $role_id[] = $v['id'];
                $role_name[] = $v['name'];
            }
        }
        $rs['role_id'] = $role_id;
        $rs['role_name'] = $role_name;
        unset($rs['password']);
        return $this->success($rs, __('tip.success'));
    }

    // 修改
    public function update(Request $request, $id)
    {
        try {
            $belongName = $this->belongName;
            $model = Admins::query()->find($id);
            $model->username = $request->username;
            if (!empty($request->password)) {
                $model->password = Hash::make($request->password);
            }
            $model->nickname = $request->nickname ?? '';
            $model->avatar = $request->avatar ?? '';
            $model->$belongName = $this->getBelongId();
            $model->save();
            $model->roles()->sync($request->role_id ?? []);
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
            $model = Admins::query()->find($v);
            $model->roles()->detach();
            $model->refresh();
        }
        $model->whereIn('id', $idArray)->where($this->belongName, $this->getBelongId())->delete();
        return $this->success([], __('tip.success'));
    }
}