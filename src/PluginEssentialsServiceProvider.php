<?php

namespace BezhanSalleh\PluginEssentials;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PluginEssentialsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-plugin-essentials');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(PluginEssentials::class, fn (): \BezhanSalleh\PluginEssentials\PluginEssentials => new PluginEssentials);
    }
}
