<?php

namespace App\Repositories\Recruitment;

use App\Models\Employer;
use App\Models\Province;
use App\Models\Recruitment;
use App\Models\RecruitmentCategory;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\BaseService;
use Illuminate\Support\Arr;

/**
 * Class EmployerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RecruitmentRepositoryEloquent extends BaseRepository implements RecruitmentRepository
{
    protected  $modelCategory;
    protected  $baseService;
    protected  $modelRecruitment;
    protected  $modelProvince;

    public function __construct(
        RecruitmentCategory $modelCategory,
        BaseService $baseService,
        Recruitment $modelRecruitment,
        Province $modelProvince
    ) {
        $this->modelCategory = $modelCategory;
        $this->baseService = $baseService;
        $this->modelRecruitment = $modelRecruitment;
        $this->modelProvince = $modelProvince;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Recruitment::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getInfo($id)
    {
        return $this->findOrFail($id);
    }
    
    public function getListRecruitmentFilter(array $params)
    {
        return $this->modelRecruitment
            ->when(isset($params['province']), function ($q) use ($params) {
                $q->where('province_id', $params['province']);
            })
            ->when(isset($params['title']), function ($q) use ($params) {
                $q->where('name', 'like', '%'.$params['title'].'%');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(config('paginate.limit'));
    }

    public function listCategory()
    {
        return RecruitmentCategory::get();
    }

    public function createRecruitment(array $params)
    {
        if ($params['thumbnail']) {
            $fullPath = $this->baseService->uploadImagesBase64($params['thumbnail']);
            
            $params['thumbnail'] = $fullPath;
        }
        
        $params['employer_id'] = auth('store')->user()->id;

        $recruitment = Recruitment::create($params);

        return $recruitment;
    }

    public function updateRecruitment(array $params)
    {
        if (isset($params['thumbnail'])) {
            $fullPath = $this->baseService->uploadImagesBase64($params['thumbnail']);
            
            $params['thumbnail'] = $fullPath;
        }
        
        $params['employer_id'] = auth('store')->user()->id;

        $recruitment = Recruitment::where('id', $params['id'])->update($params);

        return $recruitment;
    }

    public function getListRecruitmentUser(array $params)
    {
        $paginate = $params['paginate'] ?? config('paginate.default_recruit');

        return $this->modelRecruitment
            ->when(isset($params['province']), function ($q) use ($params) {
                $q->where('province_id', $params['province']);
            })
            // ->when(isset($params['title']), function ($q) use ($params) {
            //     $q->where('name', 'like', '%'.$params['title'].'%');
            // })
            ->orderBy('created_at', 'DESC')
            ->paginate($paginate);
    }

    public function getListRecruitmentFilterEmployer(array $params)
    {
        $id = Auth::user()->id;

        return $this->modelRecruitment->where('employer_id', $id)
            ->when(isset($params['province']), function ($q) use ($params) {
                $q->where('province_id', $params['province']);
            })
            ->when(isset($params['title']), function ($q) use ($params) {
                $q->where('name', 'like', '%'.$params['title'].'%');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(config('paginate.limit'));
    }

    public function getProvince()
    {
        $data = $this->modelRecruitment->pluck('province_id')->all();

        return $this->modelProvince->whereIn('id', $data)->get();
    }

}
