<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\UserCheckService;

class UserChecksController extends Controller
{

    public function edit()
    {
        return $this->handle(app(UserCheckService::class)->edit());
    }

    public function check()
    {
        return $this->handle(app(UserCheckService::class)->check());
    }
}
