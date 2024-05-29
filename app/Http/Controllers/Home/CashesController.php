<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Services\CashService;
use Illuminate\Http\Request;

class CashesController extends Controller
{
    public function index(Request $request)
    {
        $data = Cash::query()->orderBy('id', 'desc')
            ->where('user_id', $this->getUserId('users'))
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function store(Request $request)
    {
        return $this->handle(app(CashService::class)->add($request->all()));
    }
}
