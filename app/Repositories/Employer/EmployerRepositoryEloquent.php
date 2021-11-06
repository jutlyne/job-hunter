<?php

namespace App\Repositories\Employer;

use App\Enums\Prioritize;
use App\Models\Employer;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;


/**
 * 
 *
 * @package namespace App\Repositories;
 */
class EmployerRepositoryEloquent extends BaseRepository implements EmployerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employer::class;
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

    public function changeStatus($id)
    {
        $employer = $this->findOrFail($id);

        if ($employer->status == 1) {
            $employer->update(['status' => 0]);
        } else {
            $employer->update(['status' => 1]);
        }
        
        return true;
    }
    
    public function getListEmployerFilter($province_id)
    {
        return $this->where('status', 1)
            ->when($province_id, function ($query, $province_id) {
                $query->where('province_id', $province_id);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(config('paginate.limit'));
    }

    public function changePrioritize($employer)
    {
        if ($employer->prioritize == 0) {
            $employer->update([
                'prioritize' => 1,
                'prioritize_at' => Carbon::now()->format('Y-m-d H:i:00')
            ]);
        } else {
            $employer->update([
                'prioritize' => 0,
                'prioritize_at' => Carbon::now()->format('Y-m-d H:i:00')
            ]);
        }
    }

    public function handleScheduleEmployerDate()
    {
        $employer = $this->model::where([
            ['prioritize', 1],
            ['prioritize_at', Carbon::now()->addMonth()->format('Y-m-d H:i:00')]
        ])->get();

        DB::beginTransaction();

        try {
            if (!empty($employer)) {
                foreach ($employer as $item) {
                    $item->update([
                        'prioritize' => 0,
                        'prioritize_at' => null
                    ]);
                }
            }

            DB::commit();

            return true;

        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();

            return false;
        }
    }

    public function active($id)
    {
        return $this->findOrFail($id)->update([
            'prioritize' => Prioritize::ACTIVE,
            'prioritize_at' => now()
        ]);
    }
}
