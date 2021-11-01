<?php

namespace App\Repositories\District;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DistrictRepository.
 *
 * @package namespace App\Repositories;
 */
interface DistrictRepository extends RepositoryInterface
{
    public function search(array $params);
}
