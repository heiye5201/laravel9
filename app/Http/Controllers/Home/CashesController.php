<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\CashService;
use Illuminate\Http\Request;

class CashesController extends Controller
{

    public function store(Request $request)
    {
        return $this->handle(app(CashService::class)->add());
    }
}
