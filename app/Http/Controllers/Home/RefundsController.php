<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\RefundService;
use Illuminate\Http\Request;

class RefundsController extends Controller
{
    public function store(Request $request)
    {
        return $this->handle(app(RefundService::class)->add($request->all()));
    }

    public function update(Request $request, $id)
    {
        return $this->handle(app(RefundService::class)->edit($id, $request->all()));
    }

    public function show($id)
    {
        return $this->handle(app(RefundService::class)->getRefundByOrderId($id));
    }
}
