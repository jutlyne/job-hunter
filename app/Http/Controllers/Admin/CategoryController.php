<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BlogCategory;

class CategoryController extends Controller
{
    public function index ()
    {
        $categories = Category::paginate(config('paginate.default'));

        return view('admin.categories.index', compact('categories'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        BlogCategory::where('category_id', $category->id)->delete();

        return redirect()->route('admin.categories.index');
    }
}
