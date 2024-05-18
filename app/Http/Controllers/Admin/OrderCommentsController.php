<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\OrderCommentQuery;
use Illuminate\Http\Request;

class OrderCommentsController extends Controller
{

    public function index(Request $request, OrderCommentQuery $query)
    {
        $query = $query->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }


    public function update(Request $request, $id)
    {
        $request->offsetSet('reply_time', now());
        return $this->handle($this->getService('base')->editDat('OrderComment', $id, ['reply','reply_time']));
    }
}
