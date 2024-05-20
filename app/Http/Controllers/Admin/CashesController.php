<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\CashQuery;
use App\Models\Cash;
use Illuminate\Http\Request;

class CashesController extends Controller
{
    public function index(Request $request, CashQuery $query)
    {
        $isAll = $request->input('isAll', false);
        if ($isAll) {
            $data = $query->orderBy('id', 'desc')
                ->get();
        } else {
            $data = $query->orderBy('id', 'desc')
                ->paginate(intval($request->input('page_size', 25)));
        }
        return $this->success($data);
    }


    public function show($id)
    {
        $data = Cash::query()->find($id)->toArray();
        return $this->success($data);
    }


    public function update(Request $request, $id)
    {
        try {
            $data = Cash::query()->where('id', $id)->update([
                'cash_status' => $request->input('cash_status', 0),
                'remark' => $request->input('remark'),
            ]);
            return $this->handle(['status'=>200, 'data'=>$data]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ids = explode(", ", $id);
            $data = Cash::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
