<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Queries\AddressQuery;
use App\Http\Resources\Home\AddressHomeResource;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressesController extends Controller
{

    public function index(Request $request, AddressQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->where('user_id', $this->getUserId('users'))
            ->paginate(intval($request->input('page_size', 25)));;
        return $this->success($data);
    }

    public function store(Request $request)
    {
        return $this->handle(app(AddressService::class)->add($request->all()));
    }

    public function update(Request $request, $id)
    {
        return $this->handle(app(AddressService::class)->edit($id, $request->all()));
    }

    public function set_default($id)
    {
        return $this->handle(app(AddressService::class)->setDefault($id));
    }

    public function show($id)
    {
        $data = Address::query()->find($id);
        return $this->success(new AddressHomeResource($data));
    }

    public function destroy($id)
    {
        return $this->handle(app(AddressService::class)->remove($id));
    }
}
