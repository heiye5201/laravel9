<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\MoneyLogService;
use Illuminate\Http\Request;

class MoneyLogsController extends Controller
{
    public function index(Request $request)
    {
        return $this->handle(app(MoneyLogService::class)->getMoneyLog($request->all()));
    }
}
