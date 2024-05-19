<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\Admin\PermissionQuery;
use App\Models\AdminPermission;
use App\Services\BaseService;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function loadPermission()
    {
        $routes = app(BaseService::class)->getRoutes();
        return $this->handle($routes);
    }


    public function index(Request $request, PermissionQuery $query)
    {
        $data = $query->with(['permission_groups'])->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = AdminPermission::query()->find($id);
        return $this->success($data);
    }

    public function store(Request $request)
    {
        try {
            $data = AdminPermission::query()->create([
                'content' => $request->input('content'),
                'name' => $request->input('name'),
                'apis' => $request->input('apis'),
                'pid' => $request->input('pid'),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = AdminPermission::query()->where('id', $id)->update([
                'content' => $request->input('content'),
                'name' => $request->input('name'),
                'apis' => $request->input('apis'),
                'pid' => $request->input('pid'),
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
            $data = AdminPermission::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}
