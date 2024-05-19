<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\SmsLogsQuery;
use App\Models\SmsLog;
use Illuminate\Http\Request;

class SmsLogsController extends Controller
{
    public function index(Request $request, SmsLogsQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = SmsLog::query()->find($id);
        return $this->success($data);
    }


    public function destroy($id)
    {
        try {
            $ids = explode(", ", $id);
            $data = SmsLog::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
