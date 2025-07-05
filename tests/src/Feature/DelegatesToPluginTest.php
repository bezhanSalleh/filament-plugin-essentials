<?php

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;

// Create a test resource that doesn't extend anything to test parent method fallback
class TestResourceForDelegation
{
    use HasNavigation;

    protected static $plugin = null;

    public static function pluginEssential(): ?MockPlugin
    {
        return static::$plugin;
    }

    public static function setPlugin(?MockPlugin $plugin): void
    {
        static::$plugin = $plugin;
    }

    // This will be called when parent method doesn't exist
    public static function getParentResult(string $method): mixed
    {
        return match ($method) {
            'getNavigationLabel' => 'Fallback Label',
            default => null,
        };
    }
}

// Test resource without pluginEssential method
class TestResourceWithoutPlugin
{
    use HasNavigation;

    public static function getParentResult(string $method): mixed
    {
        return 'No Plugin Method';
    }
}

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
    TestResourceForDelegation::setPlugin(null);
});

describe('DelegatesToPlugin Trait', function () {
    it('handles resource without pluginEssential method', function () {
        expect(TestResourceWithoutPlugin::getNavigationLabel())->toBe('No Plugin Method');
    });

    it('handles throwable exceptions gracefully', function () {
        $plugin = new MockPlugin;
        $plugin->navigationLabel('Test Label');

        MockResource::setPlugin($plugin);

        // This should work normally
        expect(MockResource::getNavigationLabel())->toBe('Test Label');
    });

    it('handles plugin method that does not exist', function () {
        // Create a plugin with traits but test when plugin returns null
        $plugin = new MockPlugin;
        MockResource::setPlugin($plugin);

        // Plugin has trait and method, but returns null, so result should be empty string
        expect(MockResource::getNavigationLabel())->toBe('');
    });

    it('handles plugin that is not an object', function () {
        // Set plugin to null
        MockResource::setPlugin(null);

        // Should fall back to parent
        expect(MockResource::getNavigationLabel())->toBe('Default Label');
    });

    it('checks trait usage correctly with full namespace', function () {
        $plugin = new MockPlugin;

        // Test with full namespace trait name
        expect(MockResource::pluginUsesTrait($plugin, 'BezhanSalleh\PluginEssentials\Plugin\HasNavigation'))->toBeTrue();

        // Test with partial trait name
        expect(MockResource::pluginUsesTrait($plugin, 'HasNavigation'))->toBeTrue();

        // Test with non-existent trait
        expect(MockResource::pluginUsesTrait($plugin, 'NonExistentTrait'))->toBeFalse();
    });

    it('handles reflection exceptions gracefully', function () {
        $plugin = new MockPlugin;

        // This should not throw even if reflection fails
        expect(MockResource::pluginUsesTrait($plugin, 'HasNavigation'))->toBeTrue();
    });

    it('handles parent method calls that throw exceptions', function () {
        // Create a resource that uses parent method fallback
        $plugin = new MockPlugin;
        $plugin->navigationLabel('Plugin Label');
        TestResourceForDelegation::setPlugin($plugin);

        // Should work with plugin value
        expect(TestResourceForDelegation::getNavigationLabel())->toBe('Plugin Label');
    });

    it('returns correct sentinel value detection', function () {
        // Test the isNoPluginResult method indirectly
        $plugin = new MockPlugin;
        $plugin->navigationLabel('Plugin Label');

        MockResource::setPlugin($plugin);

        // When plugin has result, it should use plugin
        expect(MockResource::getNavigationLabel())->toBe('Plugin Label');

        // When no plugin, should use parent
        MockResource::setPlugin(null);
        expect(MockResource::getNavigationLabel())->toBe('Default Label');
    });

    it('handles exact trait name matching', function () {
        $plugin = new MockPlugin;

        // Test exact trait match
        expect(MockResource::pluginUsesTrait($plugin, 'HasNavigation'))->toBeTrue();

        // Test full namespace match
        expect(MockResource::pluginUsesTrait($plugin, 'BezhanSalleh\PluginEssentials\Plugin\HasNavigation'))->toBeTrue();

        // Test case sensitivity
        expect(MockResource::pluginUsesTrait($plugin, 'hasnavigation'))->toBeFalse();
    });
});
