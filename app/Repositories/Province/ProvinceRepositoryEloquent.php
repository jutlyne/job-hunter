<?php

namespace App\Repositories\Province;

use App\Models\Province;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class ProvinceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProvinceRepositoryEloquent extends BaseRepository implements ProvinceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Province::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function getListProvinceByEmployer()
    {
        return $this->model
            ->join('employers', 'employers.province_id', '=', 'provinces.id')
            ->select(['employers.province_id', 'provinces.name'])
            ->groupBy('employers.province_id')
            ->get();
    }

    public function getListProvinceByRecruit()
    {
        return $this->model
            ->join('recruitments', 'recruitments.province_id', '=', 'provinces.id')
            ->select(['recruitments.province_id', 'provinces.name'])
            ->groupBy('recruitments.province_id')
            ->get();
    }
    
    public function getProvinces($params)
    {
        if(isset($params['all']) && $params['all'] == "true")
        {
            return $this->model->all();
        }
        
    }
    
}
