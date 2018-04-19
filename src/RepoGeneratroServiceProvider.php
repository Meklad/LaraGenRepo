<?php

namespace Owllog\RepoGenerator;

use Illuminate\Support\ServiceProvider;

class RepoGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('repo-generator', function($app) {
            return new RepoGenerator;
        });

        $this->commands([RepositoryCommand::class]);
    }

    public function boot()
    {
        //
    }
}
