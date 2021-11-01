<?php

namespace App\Repositories\Application\User;

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
        ]);

        if (!empty($data)) {
            return false;
        }
        $find = [
            'user_id' => auth('user')->user()->id,
            'recruitment_id' => $params['id']
        ];

        $params['apply_date'] = Carbon::now()->format('Y-m-d H:i');
        $this->updateOrCreate($find, $params);

        return true;
    }

    public function getApply($id)
    {
        return $this->model->where('user_id', $id)->get();
    }

    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();

        return true;
    }
}
