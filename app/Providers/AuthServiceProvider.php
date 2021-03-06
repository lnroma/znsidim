<?php

namespace App\Providers;

use App\Policies\CategoryPolicy;
use App\Policies\TagsPolicy;
use App\Policies\AdminPolicy;
use App\Policies\UsersPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Riari\Forum\Models\Category;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        $gate->define('create-tags', TagsPolicy::class . '@createTags');
        $gate->define('superadmin', AdminPolicy::class . '@superadmin');
        $gate->define('photo_edit', UsersPolicy::class . '@photoOwner');
    }
}
