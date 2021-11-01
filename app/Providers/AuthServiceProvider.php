<?php

namespace App\Providers;

use App\Models\Staff;
use App\Models\User;
use App\Policies\StaffPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Staff::class => StaffPolicy::class,
    ];

    /**
     * Register any authentication / authorization service.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
