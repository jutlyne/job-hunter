<?php

namespace App\Repositories\Blog;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Models\Blog;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\BlogCategory;
use App\Models\Employer;
use Intervention\Image\Facades\Image;
use App\Services\BaseService;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{

    protected  $modelCategory;
    protected  $modelBlogCategory;
    protected  $baseService;

    public function __construct(
        Category $modelCategory,
        BlogCategory $modelBlogCategory,
        BaseService $baseService,
        Employer $modelEmployer
    ) {
        $this->modelCategory = $modelCategory;
        $this->modelBlogCategory = $modelBlogCategory;
        $this->baseService = $baseService;
        $this->modelEmployer = $modelEmployer;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Blog::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function createBlog(array $params)
    {

        if ($params['thumbnail']) {
            $fullPath = $this->baseService->uploadImagesBase64($params['thumbnail']);
            $params['thumbnail'] = $fullPath;
        }
        
        if ($params['img_content']) {
            $img_content = json_encode($params['img_content']);
        }

        $dataBlog = [
            'title' => $params['title'],
            'slug' => $params['slug'],
            'content' => $params['content'],
            'description' => $params['description'],
            'seo_title' => $params['seo_title'],
            'seo_description' => $params['seo_description'],
            'seo_keyword' => $params['seo_keyword'],
            'thumbnail' => $params['thumbnail'],
            'breadcrumb_seo_keyword' => $params['breadcrumb_seo_keyword'],
            'img_content' => $img_content
        ];
        
        $blog = Blog::create($dataBlog);

        if ($params['category']) {
            foreach ($params['category'] as $item) {
                $this->modelBlogCategory->create([
                    'blog_id' => $blog->id,
                    'category_id' => $item,
                ]);
            }
        }

        return $blog;
    }

    public function updateBlog(array $params)
    {
        if ($params['img_content']) {
            $img_content = json_encode($params['img_content']);
        }

        $dataBlog = [
            'title' => $params['title'],
            'slug' => $params['slug'],
            'description' => $params['description'],
            'content' => $params['content'],
            'seo_title' => $params['seo_title'],
            'seo_description' => $params['seo_description'],
            'seo_keyword' => $params['seo_keyword'],
            'breadcrumb_seo_keyword' => $params['breadcrumb_seo_keyword'],
            'img_content' => $img_content
        ];

        if (isset($params['thumbnail']) && $params['thumbnail']) {
            $fullPath = $this->baseService->uploadImagesBase64($params['thumbnail']);
            $dataBlog['thumbnail'] = $fullPath;
        }

        $blog = Blog::where('id', $params['id'])->update($dataBlog);

        if ($params['category']) {
            $this->modelBlogCategory->where('blog_id', $params['id'])->delete();

            foreach ($params['category'] as $item) {
                $this->modelBlogCategory->create([
                    'blog_id' => $params['id'],
                    'category_id' => $item,
                ]);
            }
        }

        return $blog;
    }

    public function listCategory()
    {
        return  $this->modelCategory->orderBy('id', 'DESC')->get();
    }


    public function getListBlog($params)
    {
        return Blog::select('blogs.*')
            ->join('blog_categories', 'blog_categories.blog_id', 'blogs.id')
            ->when($params['category'], function ($q) use ($params) {
                $q->whereIn('category_id', $params['category']);
            })
            ->when($params['title'], function ($q) use ($params) {
                $q->where('title', 'like', '%' . $params['title'] . '%');
            })
            ->orderBy('blogs.created_at', 'DESC')
            ->groupBy('blogs.id')
            ->paginate(config('paginate.default'));
    }

    public function getListBlogUser($params)
    {
        return Blog::select('blogs.*', 'category_id', 'categories.name')
            ->join('blog_categories', 'blog_categories.blog_id', 'blogs.id')
            ->when($params['category'], function ($q) use ($params) {
                $q->where('category_id', $params['category']);
            })
            ->join('categories', 'blog_categories.category_id', 'categories.id')
            ->orderBy('blogs.created_at', 'DESC')
            ->groupBy('blogs.id')
            ->paginate(config('paginate.default_blog'));
    }

    public function listBlogByCategory($params)
    {
        return Blog::select('blogs.*')
            ->join('blog_categories', 'blog_categories.blog_id', 'blogs.id')
            ->whereIn('category_id', $params['category'])
            ->where('blogs.id', '<>', $params['id'])
            ->orderBy('blogs.id', 'DESC')
            ->groupBy('blogs.id')
            ->limit(5)
            ->get();
    }

    public function getLimitBlog($params)
    {
        return Blog::select('blogs.*')
            ->where('blogs.id', '<>', $params['id'])
            ->orderBy('blogs.created_at', 'DESC')
            ->limit($params['limit'])
            ->get();
    }

    public function getOffset($offset)
    {
        return Blog::select('blogs.*')
            ->limit(10)
            ->skip($offset)
            ->get();
    }
}
