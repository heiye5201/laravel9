<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\AdvSpacesQuery;
use App\Models\AdvSpace;
use Illuminate\Http\Request;

class AdvSpacesController extends Controller
{
    public function index(Request $request, AdvSpacesQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = AdvSpace::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = AdvSpace::query()->create([
                'name' => $request->input('name'),
                'width' => $request->input('width'),
                'height' => $request->input('height'),
                'local_type' => $request->input('local_type', ''),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = AdvSpace::query()->where('id', $id)->update([
                'name' => $request->input('name'),
                'width' => $request->input('width'),
                'height' => $request->input('height'),
                'local_type' => $request->input('local_type', ''),
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
            $data = AdvSpace::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
