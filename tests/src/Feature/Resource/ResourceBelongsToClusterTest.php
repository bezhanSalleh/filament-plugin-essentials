<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
});

describe('Resource BelongsToCluster Delegation', function () {
    it('delegates getCluster to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->cluster('App\\Clusters\\TestCluster');

        MockResource::setPlugin($plugin);

        expect(MockResource::getCluster())->toBe('App\\Clusters\\TestCluster');
    });

    it('falls back to parent for getCluster when no plugin', function () {
        expect(MockResource::getCluster())->toBeNull();
    });

    it('handles null plugin result for getCluster', function () {
        $plugin = new MockPlugin;
        $plugin->cluster(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getCluster())->toBeNull();
    });

    it('handles closure values correctly for cluster', function () {
        $plugin = new MockPlugin;
        $plugin->cluster(fn () => 'App\\Clusters\\DynamicCluster');

        MockResource::setPlugin($plugin);

        expect(MockResource::getCluster())->toBe('App\\Clusters\\DynamicCluster');
    });
});
