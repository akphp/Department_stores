<?php

namespace App\Providers;

use App\Interfaces\AdminInterface;
use App\Interfaces\ConstantInterface;
use Illuminate\Support\ServiceProvider;

use App\Interfaces\PlanInterface;
use App\Mail\AdminCreated;
use App\Mail\UserCreated;
use App\Mail\UserMailChaanged;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use App\Repositories\ConstantRepository;
use App\Repositories\PlanRepository;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        // Admin::created(function($admin) {
        //     retry(5, function() use ($admin) {
        //         Mail::to($admin)->send(new AdminCreated($admin));
        //     }, 100);
        // });

        // Admin::updated(function($admin) {
        //     if ($admin->isDirty('email')) {
        //         retry(5, function() use ($admin) {
        //             Mail::to($admin)->send(new AdminMailChaanged($admin));
        //         }, 100);
        //     }
        // });

         $this->app->bind(PlanInterface::class, PlanRepository::class);

         $this->app->bind(ConstantInterface::class, ConstantRepository::class);
         $this->app->bind(AdminInterface::class, AdminRepository::class);


        /*
         * bind Offer interface with Offer repository
         * @author Amr
         */
        // $this->app->bind(PlanInterface::class, PlanRepository::class);
        // app()->make('router')->aliasMiddleware('CompanyUserAuthMiddleware', CompanyAuthMiddleware::class);
    }
}
