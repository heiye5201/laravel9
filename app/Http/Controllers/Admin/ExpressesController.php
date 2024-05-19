<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\ExpressQuery;
use App\Http\Queries\GoodsClassQuery;
use App\Models\Express;
use App\Models\GoodsClass;
use Illuminate\Http\Request;

class ExpressesController extends Controller
{

    public function index(Request $request, ExpressQuery $query)
    {
        $isAll = $request->input('isAll', false);
        if ($isAll) {
            $data = $query->orderBy('id', 'desc')->get();
        } else {
            $data = $query->orderBy('id', 'desc')
                ->paginate(intval($request->input('page_size', 25)));
        }
        return $this->success($data);
    }

    public function show($id)
    {
        $data = Express::query()->find($id);
        return $this->success($data);
    }

    public function store(Request $request)
    {
        try {
            $data = Express::query()->create([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Express::query()->where('id', $id)->update([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
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
            $data = Express::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
