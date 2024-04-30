<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConfigsRepository;
use App\Models\Configs;
use App\Validators\ConfigsValidator;

/**
 * Class ConfigsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConfigsRepositoryEloquent extends BaseRepository implements ConfigsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Configs::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
