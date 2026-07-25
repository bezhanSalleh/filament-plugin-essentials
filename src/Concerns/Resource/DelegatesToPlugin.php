<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait DelegatesToPlugin
{
    /**
     * Sentinel value to distinguish between "no plugin result" and "plugin returned null"
     */
    private static $NO_PLUGIN_RESULT = '__NO_PLUGIN_RESULT__';

    protected static function pluginOrParent(string $traitName, string $property, string $parentMethod, bool $nullFallsBack = false): mixed
    {
        $value = static::resolvePluginProperty($traitName, $property);

        if (static::isNoPluginResult($value) || ($value === null && $nullFallsBack)) {
            return static::getParentResult($parentMethod);
        }

        return $value;
    }

    protected static function resolvePluginProperty(string $traitName, string $property): mixed
    {
        $plugin = static::resolveEssentialsPluginFor($traitName);

        if ($plugin === null || ! method_exists($plugin, 'hasResolvedEssentialsProperty')) {
            return self::$NO_PLUGIN_RESULT;
        }

        try {
            if (! $plugin->hasResolvedEssentialsProperty($property, static::class)) {
                return self::$NO_PLUGIN_RESULT;
            }

            return $plugin->resolveEssentialsProperty($property, static::class);
        } catch (\Throwable) {
            return self::$NO_PLUGIN_RESULT;
        }
    }

    protected static function resolveEssentialsPluginFor(string $traitName): ?object
    {
        if (! method_exists(static::class, 'getEssentialsPlugin')) {
            return null;
        }

        try {
            $plugin = static::getEssentialsPlugin();
        } catch (\Throwable) {
            return null;
        }

        if (! is_object($plugin) || ! static::pluginUsesTrait($plugin, $traitName)) {
            return null;
        }

        return $plugin;
    }

    protected static function delegateToPlugin(string $traitName, string $methodName, mixed $fallback = null): mixed
    {
        if (! method_exists(static::class, 'getEssentialsPlugin')) {
            return self::$NO_PLUGIN_RESULT;
        }

        try {
            $plugin = static::getEssentialsPlugin();

            if (! is_object($plugin)) {

                return self::$NO_PLUGIN_RESULT;
            }

            if (! static::pluginUsesTrait($plugin, $traitName)) {

                return self::$NO_PLUGIN_RESULT;
            }

            if (! method_exists($plugin, $methodName)) {

                return self::$NO_PLUGIN_RESULT;
            }

            return $plugin->{$methodName}(static::class);

        } catch (\Throwable) {
            return self::$NO_PLUGIN_RESULT;
        }
    }

    protected static function isNoPluginResult(mixed $result): bool
    {
        return $result === self::$NO_PLUGIN_RESULT;
    }

    public static function pluginUsesTrait(object $plugin, string $traitName): bool
    {
        foreach (class_uses_recursive($plugin) as $trait) {
            if ($trait === $traitName || str_ends_with($trait, '\\' . $traitName)) {
                return true;
            }
        }

        return false;
    }

    protected static function getParentResult(string $methodName): mixed
    {
        try {
            return parent::{$methodName}();
        } catch (\Throwable) {
            return null;
        }
    }
}
