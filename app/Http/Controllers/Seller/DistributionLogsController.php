<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\DistributionLogQuery;
use App\Services\StoreService;
use Illuminate\Http\Request;

class DistributionLogsController extends Controller
{

    public function index(Request $request, DistributionLogQuery $query)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $query = $query->where('store_id', $storeId)->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }
}
