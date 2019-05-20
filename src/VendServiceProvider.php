<?php

namespace Asad\Vend;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Asad\Vend\Command\VendAuthentication;
class VendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                VendAuthentication::class,
            ]);
        }

        $this->registerResources();
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }



     /**
     * Register the package resources.
     *
     * @return void
     */
    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->registerRoutes();
    }
    
    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        });
    }
    /**
     * Get the Press route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'prefix' => '/',
            'namespace' => 'Asad\Vend\Controllers',
        ];
    }


}
