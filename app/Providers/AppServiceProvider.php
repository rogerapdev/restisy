<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Custom\Validation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new Validation($translator, $data, $rules, $messages, $attributes);
        });

    }

    protected function loadHelpers()
    {
        $helpers = $this->app['files']->glob(__DIR__ . '/../Helpers/*.php');
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }

}
