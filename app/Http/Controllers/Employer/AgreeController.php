<?php

namespace App\Http\Controllers\Employer;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\MailAgreeRequest;
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

    public function agree($id)
    {
        $info = $this->applicationRepository->getInfoAgree($id);

        return view('employer.candidate.agree', compact('info'));
    }

    public function sendMailAgree(MailAgreeRequest $request)
    {
        $this->applicationRepository->sendMailAgree($request->all());

        return redirect()->route('employer.candidate.index');
    }

    public function getZoomInfo($id)
    {
        return response()->json($this->applicationRepository->getZoomInfo($id));
    }
}
