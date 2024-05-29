<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        return $this->handle(app(FavoriteService::class)->fav($request->all()));
    }

    public function store(Request $request)
    {
        return $this->handle(app(FavoriteService::class)->add($request->all()));
    }

    public function is_fav(Request $request)
    {
        return $this->handle(app(FavoriteService::class)->isFav($request->all()));
    }
}
