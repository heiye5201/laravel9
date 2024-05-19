<?php
/**
 * autor      : jiweijian
 * createTime : 2024/4/29 10:32
 * description:
 */

namespace App\Http\Controllers;

use App\Repositories\ConfigsRepository;
use Illuminate\Http\Request;

class SpaController extends Controller
{


    protected $repository;

    public function __construct(ConfigsRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function index(Request $request)
    {
        $data = $this->repository->all()->pluck('content', 'name');
        return view('vue', $data);
    }
}