<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //自定义验证规则
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {

            $mobile = '/^1[3-9]+\d{9}$/';
            $tel = '/^\+86-1[3-9]+\d{9}$/';
            return preg_match($mobile, $value) || preg_match($tel, $value);

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
