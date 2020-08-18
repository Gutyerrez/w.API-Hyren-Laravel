<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Console\Commands\ModelMakeCommand;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->extend('command.model.make', function($command, $app) {
            return new ModelMakeCommand($app['files']);
        });
    }
}
