<?php

namespace App\Repositories\Application\Employer;

use App\Enums\EducationLevels;
use App\Enums\ExperienceEnums;
use App\Enums\Languages;
use App\Models\Application;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ApplicationRepositoryEloquent extends BaseRepository implements ApplicationRepository
{
    public function model()
    {
        return Application::class;
    }

    public function countStatusByDate($employerId, $from, $to = null)
    {
        $query = $this->model
        ->where('employer_id', $employerId)
        ->groupBy('status')
        ->select(DB::raw('COUNT(*) as count'), 'status');

        if ($to) {
            $query->whereDate('apply_date', '>=', $from)
            ->whereDate('apply_date', '<=', $to);
        } else {
            $query->whereDate('apply_date', $from);
        }
        return $query->get();
    }

    public function getAll()
    {
        return $this->model->where('employer_id', auth('store')->user()->id)->get();
    }

    public function getInfoUser($id)
    {
        $data = UserProfile::where('user_id', $id)->first();
        $data['experience'] = ExperienceEnums::getDescription($data->experience);
        $data['education'] = EducationLevels::getDescription($data->education);
        $data['language'] = Languages::getDescription($data->language);

        return $data;
    }
}
