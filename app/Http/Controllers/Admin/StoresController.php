<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\StoreQuery;
use App\Http\Resources\Admin\StoreAdminCollection;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoresController extends Controller
{

    public function index(Request $request, StoreQuery $query)
    {
        if ($request->input('store_verify')) {
            $query = $query->where('store_verify', $request->input('store_verify'));
        }
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success(new StoreAdminCollection($data));
    }


    public function show($id)
    {
        $data = Store::query()->find($id);
        return $this->success(new StoreResource($data));
    }

    public function update(Request $request, $id)
    {
        try {
            $rs = app(StoreService::class)->editStore($id, 'id', 'admins');
            return $this->handle($rs);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
