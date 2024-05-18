<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\GoodsBrandQuery;
use App\Models\GoodsBrand;
use Illuminate\Http\Request;

class GoodsBrandsController extends Controller
{

    public function index(Request $request, GoodsBrandQuery $query)
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
        $data = GoodsBrand::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = GoodsBrand::query()->create([
                'name' => $request->input('name'),
                'thumb' => $request->input('thumb'),
                'wap_logo' => $request->input('wap_logo'),
                'is_sort' => $request->input('is_sort', 0),
                'recommend' => $request->input('recommend', 0)
            ]);
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = GoodsBrand::query()->where('id', $id)->update([
                'is_sort' => $request->input('is_sort', 0),
                'name' => $request->input('name'),
                'wap_logo' => $request->input('wap_logo'),
                'thumb' => $request->input('thumb'),
                'recommend' => $request->input('recommend', 0)
            ]);
            return $this->handle(['status'=>200, 'data'=>$data]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $ids = explode(", ", $id);
            $data = GoodsBrand::query()->whereIn('id', $ids)->delete();
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
