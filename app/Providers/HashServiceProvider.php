<?php

namespace App\Providers;

use Hashids\Hashids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class HashServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Hashids::class, function ($app) {
            return new Hashids(env('HASH_SALT','abc123'), env('HASH_LENGTH','5'));
        });
    }
}
