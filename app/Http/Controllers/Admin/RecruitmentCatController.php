<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecruitmentCategory;

class RecruitmentCatController extends Controller
{
    public function index()
    {
        $categories = RecruitmentCategory::paginate(config('paginate.default'));

        return view('admin.recruitment_categories.index', compact('categories'));
    }

    public function destroy(RecruitmentCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.recruitmentcat.index');
    }
}
