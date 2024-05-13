<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/12 23:44
 * description:
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UploadsService;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    public function upload(Request $request)
    {
        $uploadType = request('uploadType', 'uploadPic');
        $name = $request->name??'';
        $option = isset($request->option) ? json_decode($request->option, true) : [];
        try {
            $rs = app(UploadsService::class)->$uploadType($name, $option);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->handle($rs);
    }
}