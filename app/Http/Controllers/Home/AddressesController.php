<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Queries\AddressQuery;
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
        return $this->handle(app(AddressService::class)->add());
    }

    public function update(Request $request, $id)
    {
        return $this->handle(app(AddressService::class)->edit($id));
    }

    public function set_default($id)
    {
        return $this->handle(app(AddressService::class)->setDefault($id));
    }
}
