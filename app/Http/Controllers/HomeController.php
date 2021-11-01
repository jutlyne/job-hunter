<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Recruitment;
use App\Models\RecruitmentCategory;
use App\Models\Test;
use App\Repositories\Province\ProvinceRepository;
use Illuminate\Http\Request;


class HomeController extends Controller
{


    public function index(Request $request)
    {
        $categories = RecruitmentCategory::get();
        $jobs = Recruitment::get();
        $blogs = Blog::orderBy('created_at', 'desc')->take(3)->get();

        return view('home', compact('categories', 'jobs', 'blogs'));
    }

}
