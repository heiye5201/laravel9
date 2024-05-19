<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\ArticleQuery;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function index(Request $request, ArticleQuery $query)
    {
        $data = $query->with(['class'])->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = Article::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = Article::query()->create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'pid' => $request->input('pid'),
                'content' => $request->input('content'),
            ]);
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Article::query()->where('id', $id)->update([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'pid' => $request->input('pid'),
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
            $data = Article::query()->whereIn('id', $ids)->delete();
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}
