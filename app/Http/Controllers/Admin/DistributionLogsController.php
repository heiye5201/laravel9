<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributionLog;
use Illuminate\Http\Request;

class DistributionLogsController extends Controller
{
    public function index(Request $request)
    {
        $query = DistributionLog::query()->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }
}
