<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\MoneyLogQuery;
use App\Models\MoneyLog;
use App\Services\StoreService;
use Illuminate\Http\Request;

class MoneyLogsController extends Controller
{

    public function index(Request $request, MoneyLogQuery $query)
    {
        $userId = app(StoreService::class)->getUserId('users');
        $data = $query->orderBy('id', 'desc')
            ->where('user_id', $userId)
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = MoneyLog::query()->find($id)->toArray();
        return $this->success($data);
    }
}
