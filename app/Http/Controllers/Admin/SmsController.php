<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\SmsQuery;
use App\Models\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function index(Request $request, SmsQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = Sms::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = Sms::query()->create([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'description' => $request->input('description'),
                'code' => $request->input('code', ''),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Sms::query()->where('id', $id)->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'description' => $request->input('description'),
                'code' => $request->input('code', ''),
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
            $data = Sms::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
