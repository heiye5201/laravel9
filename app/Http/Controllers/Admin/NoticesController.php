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

    public function show($id)
    {
        $data = Notice::query()->find($id);
        return $this->success($data);
    }


    public function store(Request $request)
    {
        try {
            $data = Notice::query()->create([
                'tag' => $request->input('tag'),
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'is_type' => 0,
                'is_send' => 0,
                'belong_id' => 0,
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Notice::query()->where('id', $id)->update([
                'tag' => $request->input('tag'),
                'name' => $request->input('name'),
                'content' => $request->input('content'),
            ]);
            return $this->handle(['status'=>200, 'data'=>$data]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $ids = explode(",", $id);
            $data = Notice::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}