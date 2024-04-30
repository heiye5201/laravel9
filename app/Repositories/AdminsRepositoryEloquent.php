<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdminsRepository;
use App\Models\Admins;
use App\Validators\AdminsValidator;

/**
 * Class AdminsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdminsRepositoryEloquent extends BaseRepository implements AdminsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admins::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
