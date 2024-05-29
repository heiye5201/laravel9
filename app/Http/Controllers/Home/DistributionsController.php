<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\DistributionService;
use Illuminate\Http\Request;

class DistributionsController extends Controller
{
    public function index(Request $request)
    {
        return $this->handle(app(DistributionService::class)->getHomeUser($request->all()));
    }
}
