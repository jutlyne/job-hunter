<?php

namespace App\Repositories\Login;

use App\Models\LoginCounter;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Helpers\UserSystemInfoHelper;
use Carbon\Carbon;

/**
 * 
 *
 * @package namespace App\Repositories;
 */
class LoginRepositoryEloquent extends BaseRepository implements LoginRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LoginCounter::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function loginInfo()
    {
        $now = Carbon::now();
        $date = $now->toDayDateTimeString();
        $browser = UserSystemInfoHelper::get_browsers();
        $device = UserSystemInfoHelper::get_device();
        $os = UserSystemInfoHelper::get_os();
        $ip = UserSystemInfoHelper::get_ip();
        $data = [
            'status' => '1',
            'date_time' => $date,
            'browser' => $browser,
            'device' => $device,
            'os' => $os,
            'ip' => $ip
        ];

        return $data;
            
    }

    
}
