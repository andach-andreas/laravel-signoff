<?php

namespace Andach\LaravelSignoff;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Andach\LaravelSignoff\Commands\LaravelSignoffCommand;

class LaravelSignoffServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-signoff')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-signoff_table')
            ->hasCommand(LaravelSignoffCommand::class);
    }
}
