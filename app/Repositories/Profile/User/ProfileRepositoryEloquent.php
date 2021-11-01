<?php

namespace App\Repositories\Profile\User;

use App\Models\Admin;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\BaseService;



/**
 * Class EmployerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProfileRepositoryEloquent extends BaseRepository implements ProfileRepository
{
    protected  $baseService;

    public function __construct(BaseService $baseService) {
        $this->baseService = $baseService;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserProfile::class;
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
    

    public function updateProfile(array $params)
    {

        $data = [
            'name' => $params['name'],
            'title' => $params['title'],
            'description' => $params['description'],
        ];


        if (isset($params['avatar'])) {

            $filename = Storage::disk('public')->put('admin', $params['avatar'], 'public');
            
            $data['avatar'] = $filename;
            Storage::disk('public')->delete(Admin::findOrFail($params['id'])->avatar);
        }

        $admin = Admin::where('id', $params['id'])->update($data);

        return $admin;
    }

}
