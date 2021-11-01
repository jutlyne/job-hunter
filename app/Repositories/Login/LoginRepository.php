<?php

namespace App\Repositories\Login;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * 
 *
 * @package namespace App\Repositories;
 */
interface LoginRepository extends RepositoryInterface
{
  public function loginInfo();
}
