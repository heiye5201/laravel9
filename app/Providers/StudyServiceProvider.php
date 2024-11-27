<?php

namespace App\Providers;

use App\Services\Study\Entity\OrderStatusService;
use App\Services\Study\Entity\ProductStatusService;
use App\Services\Study\NotificationStatusManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class StudyServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

    }

    public function register()
    {
        $this->app->afterResolving(NotificationStatusManager::class, function (NotificationStatusManager $manager) {
            $this->extendTransportManager($manager);
        });
    }

    public function extendTransportManager(NotificationStatusManager $manager)
    {
        $manager->extend('product', function () {
            return new ProductStatusService();
        });
        $manager->extend('order', function () {
            return new OrderStatusService();
        });
    }
}
