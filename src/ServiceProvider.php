<?php

namespace Devinci\LaravelUtils;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use Devinci\LaravelUtils\Command\MakeRepositoryCommand;
use Devinci\LaravelUtils\Command\SetupCommand;

// Updated command class name

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
                MakeRepositoryCommand::class, // Updated command class name
            ]);
        }
    }
}