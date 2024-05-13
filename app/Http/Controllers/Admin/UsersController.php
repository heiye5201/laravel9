<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\UserQuery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index(Request $request, UserQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            User::query()->create([
                'username' => $request->username ?? '',
                'email' => $request->email ?? '',
                'phone' => $request->phone ?? '',
                'password' => Hash::make($request->password ?? '123456'),
                'nickname' => $request->nickname ?? '',
                'avatar' => $request->avatar ?? '',
            ]);
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
        $rs = User::query()->find($id);
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
                $model->password = Hash::make($request->password);
            }
            $model->nickname = $request->nickname ?? '';
            $model->phone = $request->phone ?? '';
            $model->avatar = $request->avatar ?? '';
            $model->email = $request->email ?? '';
            $model->save();
            DB::commit();
            return $this->success([], __('tip.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    // 用户资金处理
    public function money(Request $request)
    {
        if (empty($request->id)) return $this->success();
        return $this->handle($this->getService('MoneyLog')->edit([
            'money' => $request->money ?? 1,
            'is_type' => $request->is_type ?? 0,
            'user_id' => $request->id ?? 0,
            'is_belong' => $request->is_belong ?? 0,
            'name' => __('tip.systemHandleMoney'),
        ]));
    }
}
