<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ConfigsService;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $info = app(ConfigsService::class)->getFormatConfig($request->name, $request->many_name ?? null, $request->many ?? false);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success($info);
    }


    public function edit(Request $request)
    {
        $isCustom = $request->is_custom ?? null;
        if (empty($isCustom)) {
            $resp = request()->all();
        } else {
            $resp = request()->only($isCustom);
        }
        return $this->handle(app(ConfigsService::class)->editConfig($resp));
    }

}
