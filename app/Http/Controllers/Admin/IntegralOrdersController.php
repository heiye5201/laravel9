<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\IntegralOrdersQuery;
use Illuminate\Http\Request;

class IntegralOrdersController extends Controller
{
    public function index(Request $request, IntegralOrdersQuery $query)
    {
        $query = $query->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }
}
