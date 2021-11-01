<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Application\User\ApplicationRepository;
use Illuminate\Http\Request;

class ApplyController extends Controller
{
    protected $applyRepository;

    public function __construct(ApplicationRepository $applyRepository)
    {
        $this->applyRepository = $applyRepository;
    }

    public function index()
    {
        $user = auth('user')->user();
        $apply = $this->applyRepository->getApply($user->id);

        return view('user.apply.index', compact('user', 'apply'));
    }

    public function destroy(Request $request)
    {
        return $this->applyRepository->destroy($request->id);
    }

    public function apply(Request $request)
    {
        if (!auth('user')) {
            return view('auth.login');
        } else {
            if ($this->applyRepository->userApply($request->all())) {
                return response()->json([
                    'status' => true
                ]);
            } else {
                return response()->json([
                    'status' => false
                ]);
            }
        }
    }
}
