<?php

namespace App\Repositories\Staff;

use Prettus\Repository\Contracts\RepositoryInterface;

interface StaffRepository extends RepositoryInterface
{
    public function checkPasswordCode($phone, $code);
}
