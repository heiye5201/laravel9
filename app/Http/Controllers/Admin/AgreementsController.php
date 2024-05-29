<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\AgreementQuery;
use App\Http\Requests\Admin\AgreementsRequest;
use App\Models\Agreement;
use Illuminate\Http\Request;

class AgreementsController extends Controller
{
    public function index(Request $request, AgreementQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $data = Agreement::query()->find($id);
        return $this->success($data);
    }


    public function store(AgreementsRequest $request)
    {
        try {
            $data = Agreement::query()->create([
                'name' => $request->input('name'),
                'ename' => $request->input('ename'),
                'content' => $request->input('content'),
            ]);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(AgreementsRequest $request, $id)
    {
        try {
            $data = Agreement::query()->where('id', $id)->update([
                'name' => $request->input('name'),
                'ename' => $request->input('ename'),
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
            $ids = explode(", ", $id);
            $data = Agreement::query()->whereIn('id', $ids)->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
