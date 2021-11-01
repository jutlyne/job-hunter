<?php

namespace App\Repositories\Blog;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * 
 *
 * @package namespace App\Repositories;
 */
interface BlogRepositoryInterface extends RepositoryInterface
{
    public function createBlog(array $params);

    public function updateBlog(array $params);

    public function listCategory();

    public function getListBlog($params);

    public function getListBlogUser(array $params);

    public function listBlogByCategory(array $params);

    public function getLimitBlog(array $params);
}
