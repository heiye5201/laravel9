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
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $data = $query->orderBy('id', 'desc')
            ->where('user_id', $storeId)
            ->where('is_belong', '>', 0)
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = MoneyLog::query()->find($id)->toArray();
        return $this->success($data);
    }
}
