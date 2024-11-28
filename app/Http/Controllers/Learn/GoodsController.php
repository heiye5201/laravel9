<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 15:02
 * description:
 */
namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use App\Repositories\Goods\Interfaces\GoodsRepository;
use App\Services\Study\GoodsService;
use Illuminate\Http\Request;

class GoodsController extends Controller
{

    /**
     * @var GoodsRepository
     */
    protected $repository;

    /**
     * GoodsController constructor.
     *
     * @param GoodsRepository $repository
     */
    public function __construct(GoodsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getList(Request $request)
    {
        return $this->repository->goodsPaginate($request);
    }


    public function getServerList(Request $request)
    {
        return app(GoodsService::class)->goodsPaginator($request);
    }
}