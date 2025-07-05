<?php

use BezhanSalleh\PluginEssentials\PluginEssentialsServiceProvider;

return [
    \Workbench\App\Providers\WorkbenchServiceProvider::class,
    \Workbench\App\Providers\Filament\AdminPanelProvider::class,
    PluginEssentialsServiceProvider::class,
];
