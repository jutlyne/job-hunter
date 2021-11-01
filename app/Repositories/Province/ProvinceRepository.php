<?php

namespace App\Repositories\Province;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProvinceRepository.
 *
 * @package namespace App\Repositories;
 */
interface ProvinceRepository extends RepositoryInterface
{
    public function getProvinces(array $params);
}
