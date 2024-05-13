<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/12 23:24
 * description:
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\GoodsClassQuery;
use App\Models\GoodsClass;
use App\Services\ToolService;
use Illuminate\Http\Request;

class GoodsClassesController  extends Controller
{
    public function loadMenu(Request $request)
    {
        $treeType = $request->type ?? 'getChildren';
        $deep = $request->deep ?? -1;
        $data = GoodsClass::query()->select('id', 'name', 'thumb', 'pid')
            ->orderBy('is_sort', 'asc')->get();
        try {
            $tree = app(ToolService::class)->$treeType($data, 0, 0, $deep);
        } catch (\Exception $e) {
            return $this->error(__('tip.failed'));
        }
        return $this->success($tree);
    }


    public function index(Request $request, GoodsClassQuery $query)
    {
        $data = $query->orderBy('id', 'desc')->get();
        return $this->success($data);
    }

    public function show($id)
    {
        $data = GoodsClass::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = GoodsClass::query()->create([
                'name' => $request->input('name'),
                'simple_name' => $request->input('simple_name'),
                'thumb' => $request->input('thumb'),
                'pid' => $request->input('pid'),
                'is_sort' => $request->input('is_sort'),
            ]);
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = GoodsClass::query()->where('id', $id)->update([
                'is_sort' => $request->input('is_sort'),
                'name' => $request->input('name'),
                'simple_name' => $request->input('simple_name'),
                'pid' => $request->input('pid'),
                'thumb' => $request->input('thumb'),
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
            $data = GoodsClass::query()->whereIn('id', $ids)->delete();
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}