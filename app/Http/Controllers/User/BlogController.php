<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogRating;

class BlogController extends Controller
{
    protected  $blogRepositoryInterface;

    public function __construct(BlogRepositoryInterface $blogRepositoryInterface)
    {
        $this->blogRepositoryInterface = $blogRepositoryInterface;
    }

    public function index(Category $category)
    {
        $blogs = $this->blogRepositoryInterface->getListBlogUser(['category' => $category->id]);
        
        return view('user.blog.index', compact('blogs'));
    }

    public function detail(Blog $blog)
    {
        return view('user.blog.detail', compact('blog'));
    }

    public function loadMore($id)
    {
        $blog = $this->blogRepositoryInterface->getOffset($id);

        return response()->json([
            'blog' => $blog
        ]);
    }
}
