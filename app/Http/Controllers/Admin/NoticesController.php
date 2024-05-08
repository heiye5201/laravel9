<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/6 21:55
 * description:
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\NoticesQuery;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticesController extends Controller
{
    public function index(Request $request, NoticesQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }


    public function info($id)
    {
        $data = Notice::query()->find($id);
        return $this->success($data);
    }
}