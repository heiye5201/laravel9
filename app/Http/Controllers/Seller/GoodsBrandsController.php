<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\GoodsBrandQuery;
use App\Models\GoodsBrand;
use Illuminate\Http\Request;

class GoodsBrandsController extends Controller
{
    public function index(Request $request, GoodsBrandQuery $query)
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
        $data = GoodsBrand::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = GoodsBrand::query()->create([
                'name' => $request->input('name'),
                'ename' => $request->input('ename'),
                'content' => $request->input('content'),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = GoodsBrand::query()->where('id', $id)->update([
                'name' => $request->input('name'),
                'ename' => $request->input('ename'),
                'content' => $request->input('content'),
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
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
