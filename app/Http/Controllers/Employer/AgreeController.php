<?php

namespace App\Http\Controllers\Employer;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Repositories\Application\Employer\ApplicationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AgreeController extends Controller
{
    protected $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function refuse($id)
    {
        $this->applicationRepository->sendEmailRefuse($id);

        return redirect()->route('employer.candidate.index');
    }
}
