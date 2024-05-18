<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function article(Request $request)
    {
        $article = Article::query()->where('type', $request->type ?? '')->first();
        if ($article) {
            $article->increment('click');
            return $this->success($article);
        }
        return $this->error($article);
    }
}
