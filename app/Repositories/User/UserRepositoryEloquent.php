<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Enums\ListTest;
use Illuminate\Support\Arr;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function model()
    {
        return User::class;
    }

    public function updateProfile(array $params, $user)
    {
        try {
            $this->update($params, $user->id);
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }

    public function getListUserFilter($params)
    {
        return $this->model->get();
    }
}
