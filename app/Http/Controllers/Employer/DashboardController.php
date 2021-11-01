<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Repositories\Application\Employer\ApplicationRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    protected $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function index(Request $request)
    {
        $employerId = auth('store')->user()->employer_id;
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $firstOfMonth = Carbon::now()->firstOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $applicationToday = $this->applicationRepository->countStatusByDate($employerId, $today);
        $applicationMonth = $this->applicationRepository->countStatusByDate($employerId, $firstOfMonth, $endOfMonth);
        $applicationFilter = $this->applicationRepository->countStatusByDate($employerId, Carbon::parse($request->start_time), Carbon::parse($request->end_time));

        return view('employer.dashboard', compact('applicationToday', 'applicationFilter', 'applicationMonth'));
    }
}
