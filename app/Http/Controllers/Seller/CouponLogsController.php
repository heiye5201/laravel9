<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\CouponLogsQuery;
use App\Models\CouponLog;
use Illuminate\Http\Request;

class CouponLogsController extends Controller
{
    protected $modelName = 'CouponLog';

    public function index(Request $request, CouponLogsQuery $query)
    {
        $query = $query->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = CouponLog::query()->find($id)->toArray();
        return $this->success($data);
    }
}
