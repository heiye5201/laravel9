<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\UserQuery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $auth = 'users';

    public function index(Request $request, UserQuery $query)
    {
        $isAll = $request->input('isAll', false);
        $query = $query->orderBy('id', 'desc')->where('belong_id', '>', 0);
        if ($isAll) {
            $data = $query->get();
        } else {
            $data = $query->paginate(intval($request->input('page_size', 25)));
        }
        return $this->success($data);
    }

    // 添加
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $model = User::query()
                ->create([
                    'username' => $request->username ?? '',
                    'password' => Hash::make($request->password ?? '123456'),
                    'nickname' => $request->username ?? 'Mysterious',
                    'avatar' => $request->avatar ?? '',
                    'belong_id' => $this->getBelongId()
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
        $rs = User::query()->where('belong_id', $this->getBelongId())->with(['roles'])->find($id);
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
            $model = User::query()->find($id);
            $model->username = $request->username;
            if (!empty($request->password)) {
                Hash::make($request->password);
            }
            $model->nickname = $request->nickname ?? '';
            $model->avatar = $request->avatar ?? '';
            $model->belong_id = $this->getBelongId();
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
            return (is_numeric($item));
        });
        foreach ($idArray as $v) {
            $model = User::query()->find($v);
            $model->roles()->detach();
            $model->refresh();
        }
        $model->whereIn('id', $idArray)->where('belong_id', $this->getBelongId())->delete();
        return $this->success([], __('tip.success'));
    }
}
