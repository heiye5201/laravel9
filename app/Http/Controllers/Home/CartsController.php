<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartsController extends Controller
{

    public function index(Request $request)
    {
        return $this->handle(app(CartService::class)->getCart());
    }

    public function store(Request $request)
    {
        return $this->handle(app(CartService::class)->addCart());
    }

    public function update(Request $request, $id)
    {
        return $this->handle(app(CartService::class)->editCart($id));
    }

    public function count()
    {
        return $this->handle(app(CartService::class)->getCount());
    }
}
