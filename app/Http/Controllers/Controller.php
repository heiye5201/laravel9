<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use App\Traits\ResourceTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResourceTrait;

    protected $auth = 'admins';

    public function getBelongId($auth = '')
    {
        return app(BaseService::class)->getBelongId(empty($auth) ? $this->auth : $auth);
    }


    public function getUserId($auth = '')
    {
        return app(BaseService::class)->getUserId(empty($auth) ? $this->auth : $auth);
    }


    public function getSuper($auth = '')
    {
        return app(BaseService::class)->getSuper(empty($auth) ? $this->auth : $auth);
    }

    // get Roles
    public function getRoles($auth = '', $with = ['menus', 'permissions'])
    {
        return app(BaseService::class)->getRoles(empty($auth) ? $this->auth : $auth, $with);
    }
}
