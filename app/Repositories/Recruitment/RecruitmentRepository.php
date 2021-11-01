<?php

namespace App\Repositories\Recruitment;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EmployerRepository.
 *
 * @package namespace App\Repositories;
 */
interface RecruitmentRepository extends RepositoryInterface
{
    public function listCategory();
}
