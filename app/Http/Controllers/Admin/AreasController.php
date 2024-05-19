<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\AreaQuery;
use App\Http\Resources\Admin\AreaBaseCollection;
use App\Models\Area;
use App\Services\ToolService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AreasController extends Controller
{

    public function index(Request $request, AreaQuery $query)
    {
        $isChildren = boolval(request('isChildren') ?? false);
        if ($isChildren) {
            $belong_id = request('pid') ?? 0;
            $query = $query->where('pid', $belong_id)->with('hasChildren');
        }
        $data = $query->orderBy('id', 'desc')->get();
        return $this->success($data);
    }

    public function loadArea(Request $request)
    {
        $treeType = $request->type ?? 'getAreaChildren';
        $deep = $request->deep ?? -1;
        // 懒加载数据
        if (isset($request->isLazy) && $request->isLazy) {
            $pid = $request->pid ?? 0;
            $area = Area::query()->where('pid', $pid)->orderBy('id')->get();
            return $this->success(new AreaBaseCollection($area));
        }
        $data = Area::query()->select('id', 'name', 'code', 'pid')->get();
        try {
            if (Cache::has('area') && $deep == -1) {
                return $this->success(Cache::get('area'));
            }
            $tree = app(ToolService::class)->$treeType($data, 0, 0, $deep);
            if ($deep == -1) {
                Cache::put('area', $tree);
            }
        } catch (\Exception $e) {
            return $this->error(__('tip.failed'));
        }
        return $this->success($tree);
    }

    // 清除缓存
    public function clear_area()
    {
        if (Cache::has('area')) {
            Cache::forget('area');
        }
        $data = Area::query()->select('id', 'name', 'code', 'pid')->get();
        $tree = app(ToolService::class)->getAreaChildren($data, 0, 0, -1);
        Cache::put('area', $tree);
        return $this->success($tree);
    }


    public function show($id)
    {
        $data = Area::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = Area::query()->create([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'pid' => $request->input('pid'),
                'deep'=> $request->input('deep', 0),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Area::query()->where('id', $id)->update([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'pid' => $request->input('pid'),
                'deep'=> $request->input('deep', 0),
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
            $data = Area::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
