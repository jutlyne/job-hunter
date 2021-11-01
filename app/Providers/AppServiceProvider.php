<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application service.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application service.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        JsonResource::withoutWrapping();

        //share data blog categories
        $shareBlogCategories = Category::all();
        View::share('shareBlogCategories', $shareBlogCategories);
        //share data 3 blogs
        $shareDataBlog = Blog::orderBy('created_at', 'desc')->take(3)->get();
        View::share('shareDataBlog', $shareDataBlog);
        //share data profile
        $shareDataProfile = Admin::take(1)->get();
        View::share('shareDataProfile', $shareDataProfile);
    }

}
