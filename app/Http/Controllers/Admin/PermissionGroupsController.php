<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\Admin\PermissionGroupsQuery;
use App\Models\AdminPermissionGroup;
use Illuminate\Http\Request;

class PermissionGroupsController extends Controller
{

    public function index(Request $request, PermissionGroupsQuery $query)
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

    public function show($id)
    {
        $data = AdminPermissionGroup::query()->find($id);
        return $this->success($data);
    }

    public function store(Request $request)
    {
        try {
            $data = AdminPermissionGroup::query()->create([
                'content' => $request->input('content'),
                'name' => $request->input('name'),
            ]);
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = AdminPermissionGroup::query()->where('id', $id)->update([
                'content' => $request->input('content'),
                'name' => $request->input('name'),
            ]);
            return $this->handle(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $ids = explode(",", $id);
            $data = AdminPermissionGroup::query()->whereIn('id', $ids)->delete();
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
