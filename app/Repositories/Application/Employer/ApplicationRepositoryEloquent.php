<?php

namespace App\Repositories\Application\Employer;

use App\Models\Application;
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
}
