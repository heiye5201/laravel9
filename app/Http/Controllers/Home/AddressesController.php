<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressesController extends Controller
{

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
