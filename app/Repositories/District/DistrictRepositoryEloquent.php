<?php

namespace App\Repositories\District;

use App\Models\District;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class DistrictRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DistrictRepositoryEloquent extends BaseRepository implements DistrictRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return District::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function search($params)
    {
        $district = array('data' => $this->all());

        if(isset($params['province'])) {
            $district = array('data' => $this->findWhere(['province_id' => $params['province']]));
        }

        if(isset($params['page'])) {
            if($params['province']) {
                $district = $this->where('province_id', $params['page'])->paginate(config('paginate.limit'));
            } else {
                $district = $this->paginate(config('paginate.limit'));
            }
        }

        return $district;
    }
}
