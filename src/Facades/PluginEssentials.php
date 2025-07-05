<?php

namespace BezhanSalleh\PluginEssentials\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BezhanSalleh\PluginEssentials\PluginEssentials
 */
class PluginEssentials extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BezhanSalleh\PluginEssentials\PluginEssentials::class;
    }
}
