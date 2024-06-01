<?php
/**
 * autor      : jiweijian
 * createTime : 2024/6/1 07:30
 * description:
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\RefundService;
use Illuminate\Http\Request;

class RefundsController extends Controller
{
    public function update(Request $request, $id)
    {
        return $this->handle(app(RefundService::class)->edit($id, $request->all(), 'seller'));
    }
}