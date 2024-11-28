<?php

namespace App\Repositories\Goods;

use App\Models\Goods;
use App\Repositories\Goods\Interfaces\GoodsRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class GoodsRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Goods;
 */
class GoodsRepositoryEloquent extends BaseRepository implements GoodsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Goods::class;
    }

    protected $fieldSearchable = [
        'goods_name'=>'like',
        'goods_subname'=>'like',
        'goods_no'=>'like',
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function goodsPaginate($request)
    {
        // TODO: Implement goodsPaginate() method.
        $this->applyCriteria();
        $this->applyScope();
        $limit = (int)($data['page_size'] ?? 25);
        $limit = abs($limit) < 2000 ? abs($limit) : 2000;
        $page = abs((int)($data['page'] ?? 1));
        $results = $this->model->paginate($limit, ['*'], $pageName = 'page', $page);
        $this->resetModel();
        return $this->parserResult($results);
    }

    public function createGoods(array $data)
    {
        // TODO: Implement createGoods() method.

    }

    public function updateGoods(int $id, array $data)
    {
        // TODO: Implement updateGoods() method.
    }
}
