<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        return $this->handle(app(FavoriteService::class)->fav());
    }

    public function store(Request $request)
    {
        return $this->handle(app(FavoriteService::class)->add());
    }

    public function is_fav()
    {
        return $this->handle(app(FavoriteService::class)->isFav());
    }
}
