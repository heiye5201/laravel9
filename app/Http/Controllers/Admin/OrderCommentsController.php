<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\OrderCommentQuery;
use App\Http\Resources\OrderCommentCollection;
use App\Http\Resources\OrderCommentResource;
use App\Models\OrderComment;
use App\Services\StoreService;
use Illuminate\Http\Request;

class OrderCommentsController extends Controller
{

    protected $auth = 'admins';


    public function index(Request $request, OrderCommentQuery $query)
    {
        $query = $query->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success(new OrderCommentCollection($data));
    }


    public function show($id)
    {
        $data = OrderComment::query()->find($id);
        return $this->success(new OrderCommentResource($data));
    }

    public function update(Request $request, $id)
    {
        $request->offsetSet('reply_time', now());
        $res = OrderComment::query()->where('id', $id)
            ->update([
                'reply' => $request->input('reply'),
                'reply_time' => $request->input('reply_time'),
            ]);
        return $this->success($res);
    }
}
