<?php

namespace Mahdi\LaravelCrudGenerator;

use Illuminate\Support\ServiceProvider;
use Mahdi\LaravelCrudGenerator\Commands\MakeCrudCommand;

class CrudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCrudCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/stubs' => base_path('stubs/vendor/crud-generator'),
            ], 'crud-generator-stubs');
        }
    }

    public function register()
    {
        //
    }
}
