<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Models\Category;
use App\Http\Requests\Admin\Blog\CreateRequest;
use App\Models\Blog;
use App\Http\Requests\Admin\Blog\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\BlogCategory;
use App\Traits\ImageHandle;

class BlogController extends Controller
{
    use ImageHandle;
    
    protected  $blogRepositoryInterface;

    public function __construct(BlogRepositoryInterface $blogRepositoryInterface)
    {
        $this->blogRepositoryInterface = $blogRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = $this->blogRepositoryInterface->getListBlog([
            'title' => $request->title, 
            'category' => $request->category, 
        ]);
        // dd($blogs);
        $listCategory = $this->blogRepositoryInterface->listCategory();

        return view('admin.blogs.index', compact('blogs', 'listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listCategory = $this->blogRepositoryInterface->listCategory();

        return view('admin.blogs.create', compact('listCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $this->blogRepositoryInterface->createBlog($request->validated());

        return redirect()->route('admin.blogs.index');
    }

    public function edit(Blog $blog)
    {
        $listCategory = $this->blogRepositoryInterface->listCategory();
        $blogCategories = [];
        
        foreach ($blog->blogCategories as $item)
        {  
            $blogCategories[] = $item->category_id;
        }

        return view('admin.blogs.edit', compact('listCategory', 'blog', 'blogCategories'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $this->blogRepositoryInterface->updateBlog($data);

        return redirect()->route('admin.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $json = Blog::findOrFail($id)->img_content;
        $arrContent = json_decode($json);
        $explode = explode(',', $arrContent[0]);
        
        foreach ($explode as $item) {
            Storage::disk()->delete($item);
        }

        Storage::disk()->delete(Blog::findOrFail($id)->thumbnail);
        Blog::where(['id' => $id])->delete();
        BlogCategory::where('blog_id', $id)->delete();
        
        return redirect()->route('admin.blogs.index');
    }

    public function checkCategory(Request $request)
    {
        return Category::where('name', $request->category)->count();
    }

    public function createCategory(Request $request)
    {
        $count = Category::where('name', $request->category)->count();
        
        if ($count <= 0) {
            return Category::create(['name' => $request->category]);
        } else {
            return false;
        }
    }


}
