<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\OrderCommentQuery;
use App\Models\OrderComment;
use App\Services\StoreService;
use Illuminate\Http\Request;

class OrderCommentsController extends Controller
{
    protected $auth = 'users';

    public function index(Request $request, OrderCommentQuery $query)
    {
        $query = $query->where('store_id', app(StoreService::class)->getStoreId()['data'])
            ->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        $request->offsetSet('reply_time', now());
        $res = OrderComment::query()->where('id', $id)
            ->where('store_id', app(StoreService::class)->getStoreId()['data'])
            ->update([
                'reply' => $request->input('reply'),
                'reply_time' => $request->input('reply_time'),
            ]);
        return $this->success($res);
    }
}
