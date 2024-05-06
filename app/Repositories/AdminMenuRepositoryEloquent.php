<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdminMenuRepository;
use App\Models\AdminMenu;
use App\Validators\AdminMenuValidator;

/**
 * Class AdminMenuRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdminMenuRepositoryEloquent extends BaseRepository implements AdminMenuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminMenu::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
