<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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

    public function boot()
    {
//        if (DB::getDriverName() === 'sqlite') {
//            $path = DB::getConfig('database');
//            if (!file_exists($path) && is_dir(dirname($path))) {
//                touch($path);
//            }
//        }
    }
}
