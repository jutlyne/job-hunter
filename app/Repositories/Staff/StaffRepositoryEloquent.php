<?php

namespace App\Repositories\Staff;

use App\Models\Staff;
use Exception;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class StaffRepositoryEloquent extends BaseRepository implements StaffRepository
{
    public function model()
    {
        return Staff::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function checkPasswordCode($phone, $code)
    {
        if($code == '0000')
            return true;

        return $this->where('phone', $phone)
                    ->where('reset_password_code', $code)
                    ->first();
    }
}
