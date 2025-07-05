<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
});

describe('Resource BelongsToParent Delegation', function () {
    it('delegates getParentResource to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->parentResource('App\\Resources\\ParentResource');

        MockResource::setPlugin($plugin);

        expect(MockResource::getParentResource())->toBe('App\\Resources\\ParentResource');
    });

    it('falls back to parent for getParentResource when no plugin', function () {
        expect(MockResource::getParentResource())->toBeNull();
    });

    it('handles null plugin result for getParentResource', function () {
        $plugin = new MockPlugin;
        $plugin->parentResource(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getParentResource())->toBeNull();
    });

    it('handles closure values correctly for parent resource', function () {
        $plugin = new MockPlugin;
        $plugin->parentResource('App\\Resources\\DynamicParentResource');

        MockResource::setPlugin($plugin);

        expect(MockResource::getParentResource())->toBe('App\\Resources\\DynamicParentResource');
    });
});
