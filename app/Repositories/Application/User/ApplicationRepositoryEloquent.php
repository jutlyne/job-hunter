<?php

namespace App\Repositories\Application\User;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;

class ApplicationRepositoryEloquent extends BaseRepository implements ApplicationRepository
{
    public function model()
    {
        return Application::class;
    }

    public function userApply($params)
    {
        $data = $this->where([
            ['user_id', auth('user')->user()->id],
            ['recruitment_id', $params['id']]
        ])->get();

        if (count($data) != 0) {
            return false;
        }

        $find = [
            'user_id' => auth('user')->user()->id,
            'recruitment_id' => $params['id']
        ];

        $params['status'] = ApplicationStatus::PENDING;
        $params['apply_date'] = Carbon::now()->format('Y-m-d H:i');

        return $this->updateOrCreate($find, $params);
    }

    public function getApply($id)
    {
        return $this->model->where('user_id', $id)->get();
    }

    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);

        if ($data->status == ApplicationStatus::CANCELED) {
            return false;
        }

        return $data->delete();
    }
}
