<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\UserCheckService;
use Illuminate\Http\Request;

class UserChecksController extends Controller
{

    public function edit(Request $request)
    {
        return $this->handle(app(UserCheckService::class)->edit($request->all()));
    }

    public function check(Request $request)
    {
        $data = $request->only(['name','card_no','card_t','card_b','bank_no','bank_name']);
        return $this->handle(app(UserCheckService::class)->check($data));
    }
}
