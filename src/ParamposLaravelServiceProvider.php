<?php

namespace Hemengeliriz\ParamposLaravel;

use Hemengeliriz\ParamposLaravel\Commands\ParamposLaravelCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ParamposLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('parampos-laravel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_parampos-laravel_table')
            ->hasCommand(ParamposLaravelCommand::class);
    }
}
