<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\IntegralOrdersQuery;
use App\Http\Resources\IntegralOrderCollection;
use App\Models\IntegralOrder;
use Illuminate\Http\Request;

class IntegralOrdersController extends Controller
{
    public function index(Request $request, IntegralOrdersQuery $query)
    {
        $query = $query->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success(new IntegralOrderCollection($data));
    }

    public function show($id)
    {
        $data = IntegralOrder::query()->find($id);
        return $this->success($data);
    }


    public function update(Request $request, $id)
    {
        try {
            $data = IntegralOrder::query()->where('id', $id)->update([
                'delivery_code' => $request->input('delivery_code'),
                'delivery_no' => $request->input('delivery_no'),
                'delivery_time' => $request->input('delivery_time'),
                'order_status' => $request->input('order_status')
            ]);
            return $this->handle(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
