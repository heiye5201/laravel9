<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\AdvsQuery;
use App\Models\Adv;
use Illuminate\Http\Request;

class AdvsController extends Controller
{
    public function index(Request $request, AdvsQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = Adv::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = Adv::query()->create([
                'pid'=> $request->input('pid'),
                'url'=> $request->input('url'),
                'name'=> $request->input('name'),
                'is_type'=> $request->input('is_type'),
                'adv_start'=> $request->input('adv_start'),
                'adv_end'=> $request->input('adv_end'),
                'status'=> $request->input('status'),
                'is_sort'=> $request->input('is_sort'),
                'image'=> $request->input('image'),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Adv::query()->where('id', $id)->update([
                'pid'=> $request->input('pid'),
                'url'=> $request->input('url'),
                'name'=> $request->input('name'),
                'is_type'=> $request->input('is_type'),
                'adv_start'=> $request->input('adv_start'),
                'adv_end'=> $request->input('adv_end'),
                'status'=> $request->input('status'),
                'is_sort'=> $request->input('is_sort'),
                'image'=> $request->input('image'),
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
            $data = Adv::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
