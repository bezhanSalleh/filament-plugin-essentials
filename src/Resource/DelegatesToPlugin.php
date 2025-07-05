<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Resource;

use ReflectionClass;
use ReflectionException;

trait DelegatesToPlugin
{
    /**
     * Sentinel value to distinguish between "no plugin result" and "plugin returned null"
     */
    private static $NO_PLUGIN_RESULT = '__NO_PLUGIN_RESULT__';

    /**
     * Delegates a method call to the plugin if conditions are met, otherwise falls back to parent.
     *
     * @param  string  $traitName  The trait name to check for on the plugin
     * @param  string  $methodName  The method name to call on the plugin
     * @param  mixed  $fallback  The fallback value if delegation fails
     */
    protected static function delegateToPlugin(string $traitName, string $methodName, mixed $fallback = null): mixed
    {
        // Check if pluginEssential method exists
        if (! method_exists(static::class, 'pluginEssential')) {
            return self::$NO_PLUGIN_RESULT;
        }

        try {
            // Get plugin instance
            $plugin = static::pluginEssential();

            if (! is_object($plugin)) {
                return self::$NO_PLUGIN_RESULT;
            }

            // Check if plugin uses the expected trait
            if (! static::pluginUsesTrait($plugin, $traitName)) {
                return self::$NO_PLUGIN_RESULT;
            }

            // Check if plugin has the required method
            if (! method_exists($plugin, $methodName)) {
                return self::$NO_PLUGIN_RESULT;
            }

            // Call the plugin method and return result (even if null)
            return $plugin->{$methodName}();
        } catch (\Throwable) {
            // Gracefully fall back on any error
            return self::$NO_PLUGIN_RESULT;
        }
    }

    /**
     * Check if the result indicates no plugin delegation occurred.
     */
    protected static function isNoPluginResult(mixed $result): bool
    {
        return $result === self::$NO_PLUGIN_RESULT;
    }

    /**
     * Check if a plugin object uses a specific trait.
     */
    public static function pluginUsesTrait(object $plugin, string $traitName): bool
    {
        try {
            $reflection = new ReflectionClass($plugin);
            $traits = $reflection->getTraitNames();

            // Check for exact trait name match (with namespace)
            foreach ($traits as $trait) {
                if (str_ends_with($trait, $traitName) || $trait === $traitName) {
                    return true;
                }
            }

            return false;
        } catch (ReflectionException) {
            return false;
        }
    }

    /**
     * Gets the parent method result for fallback.
     */
    protected static function getParentResult(string $methodName): mixed
    {
        try {
            return parent::{$methodName}();
        } catch (\Throwable) {
            return null;
        }
    }
}
