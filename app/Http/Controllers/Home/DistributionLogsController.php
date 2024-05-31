<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/31 22:20
 * description:
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\DistributionService;
use Illuminate\Http\Request;

class DistributionLogsController extends Controller
{
    public function index(Request $request)
    {
        return $this->handle(app(DistributionService::class)->getLogList($request->all()));
    }
}