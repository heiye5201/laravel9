<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/12 20:22
 * description:
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\ArticleMenuQuery;
use App\Http\Requests\Admin\ArticleMenusRequest;
use App\Models\ArticleMenu;
use App\Services\ArticleMenusService;
use Illuminate\Http\Request;

class ArticleMenusController extends Controller
{

    public function loadMenu(Request $request)
    {
        try {
            $tree = app(ArticleMenusService::class)->loadMenu($request->all());
        } catch (\Exception $e) {
            return $this->error(__('tip.failed'));
        }
        return $this->success($tree);
    }


    public function index(Request $request, ArticleMenuQuery $query)
    {
        $data = $query->orderBy('id', 'desc')->get();
        return $this->success($data);
    }

    public function show($id)
    {
        $data = ArticleMenu::query()->find($id);
        return $this->success($data);
    }


    public function store(ArticleMenusRequest $request)
    {
        try {
            $data = ArticleMenu::query()->create([
                'name' => $request->input('name'),
                'is_sort' => $request->input('is_sort'),
                'pid' => $request->input('pid'),
            ]);
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(ArticleMenusRequest $request, $id)
    {
        try {
            $data = ArticleMenu::query()->where('id', $id)->update([
                'is_sort' => $request->input('is_sort'),
                'name' => $request->input('name'),
                'pid' => $request->input('pid'),
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
            $data = ArticleMenu::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
