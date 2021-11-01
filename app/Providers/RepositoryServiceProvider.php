<?php

namespace App\Providers;

use App\Repositories\District\DistrictRepository;
use App\Repositories\District\DistrictRepositoryEloquent;
use App\Repositories\Employer\EmployerRepository;
use App\Repositories\Employer\EmployerRepositoryEloquent;
use App\Repositories\Province\ProvinceRepository;
use App\Repositories\Province\ProvinceRepositoryEloquent;
use App\Repositories\Staff\StaffRepository;
use App\Repositories\Staff\StaffRepositoryEloquent;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Repositories\Login\LoginRepository;
use App\Repositories\Login\LoginRepositoryEloquent;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\Profile\ProfileRepositoryEloquent;
use App\Repositories\Application\ApplicationRepository;
use App\Repositories\Application\ApplicationRepositoryEloquent;
use App\Repositories\Application\User\ApplicationRepository as UserApplicationRepository;
use App\Repositories\Application\User\ApplicationRepositoryEloquent as UserApplicationRepositoryEloquent;
use App\Repositories\Application\Employer\ApplicationRepository as EmployerApplicationRepository;
use App\Repositories\Application\Employer\ApplicationRepositoryEloquent as EmployerApplicationRepositoryEloquent;
use App\Repositories\Recruitment\RecruitmentRepository;
use App\Repositories\Recruitment\RecruitmentRepositoryEloquent;
use App\Repositories\Profile\User\ProfileRepository as UserProfileRepository;
use App\Repositories\Profile\User\ProfileRepositoryEloquent as UserProfileRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var \string[][]
     */
    protected $repositories = [
        [
            'abstract' => EmployerRepository::class,
            'concrete' => EmployerRepositoryEloquent::class,
        ],
        [
            'abstract' => UserRepository::class,
            'concrete' => UserRepositoryEloquent::class,
        ],
        [
            'abstract' => RecruitmentRepository::class,
            'concrete' => RecruitmentRepositoryEloquent::class,
        ],
        [
            'abstract' => ProvinceRepository::class,
            'concrete' => ProvinceRepositoryEloquent::class,
        ],
        [
            'abstract' => DistrictRepository::class,
            'concrete' => DistrictRepositoryEloquent::class,
        ],
        [
            'abstract' => StaffRepository::class,
            'concrete' => StaffRepositoryEloquent::class,
        ],
        [
            'abstract' => BlogRepositoryInterface::class,
            'concrete' => BlogRepository::class,
        ],
        [
            'abstract' => LoginRepository::class,
            'concrete' => LoginRepositoryEloquent::class,
        ],
        [
            'abstract' => ProfileRepository::class,
            'concrete' => ProfileRepositoryEloquent::class,
        ],
        [
            'abstract' => UserApplicationRepository::class,
            'concrete' => UserApplicationRepositoryEloquent::class,
        ],
        [
            'abstract' => EmployerApplicationRepository::class,
            'concrete' => EmployerApplicationRepositoryEloquent::class,
        ],
        [
            'abstract' => UserProfileRepository::class,
            'concrete' => UserProfileRepositoryEloquent::class,
        ],
    ];

    /**
     * Register service.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $repository) {
            $this->app->bind($repository['abstract'], $repository['concrete']);
        }
    }

    /**
     * Bootstrap service.
     *
     * @return void
     */
    public function boot()
    {
    }
}
