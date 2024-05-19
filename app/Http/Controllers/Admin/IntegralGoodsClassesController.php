<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\Admin\IntegralGoodsClassQuery;
use App\Models\IntegralGoodsClass;
use Illuminate\Http\Request;

class IntegralGoodsClassesController extends Controller
{
    public function index(Request $request, IntegralGoodsClassQuery $query)
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

    public function show($id)
    {
        $data = IntegralGoodsClass::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = IntegralGoodsClass::query()->create([
                'name' => $request->input('name'),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = IntegralGoodsClass::query()->where('id', $id)->update([
                'name' => $request->input('name'),
            ]);
            return $this->handle(['status'=>200, 'data'=>$data]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $ids = explode(",", $id);
            $data = IntegralGoodsClass::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
