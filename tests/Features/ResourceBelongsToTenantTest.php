<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
});

describe('Resource BelongsToTenant Delegation', function () {
    it('delegates isScopedToTenant to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->scopeToTenant(true);

        MockResource::setPlugin($plugin);

        expect(MockResource::isScopedToTenant())->toBeTrue();
    });

    it('falls back to parent for isScopedToTenant when no plugin', function () {
        expect(MockResource::isScopedToTenant())->toBeFalse();
    });

    it('handles boolean false plugin result for isScopedToTenant', function () {
        $plugin = new MockPlugin;
        $plugin->scopeToTenant(false);

        MockResource::setPlugin($plugin);

        expect(MockResource::isScopedToTenant())->toBeFalse();
    });

    it('delegates getTenantRelationshipName to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->tenantRelationshipName('tenant');

        MockResource::setPlugin($plugin);

        expect(MockResource::getTenantRelationshipName())->toBe('tenant');
    });

    it('falls back to parent for getTenantRelationshipName when no plugin', function () {
        expect(MockResource::getTenantRelationshipName())->toBeNull();
    });

    it('handles null plugin result for getTenantRelationshipName', function () {
        $plugin = new MockPlugin;
        $plugin->tenantRelationshipName(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getTenantRelationshipName())->toBeNull();
    });

    it('delegates getTenantOwnershipRelationshipName to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->tenantOwnershipRelationshipName('tenant');

        MockResource::setPlugin($plugin);

        expect(MockResource::getTenantOwnershipRelationshipName())->toBe('tenant');
    });

    it('falls back to parent for getTenantOwnershipRelationshipName when no plugin', function () {
        expect(MockResource::getTenantOwnershipRelationshipName())->toBeNull();
    });

    it('handles null plugin result for getTenantOwnershipRelationshipName', function () {
        $plugin = new MockPlugin;
        $plugin->tenantOwnershipRelationshipName(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getTenantOwnershipRelationshipName())->toBeNull();
    });

    it('handles closure values correctly for tenant methods', function () {
        $plugin = new MockPlugin;
        $plugin->scopeToTenant(fn () => true)
            ->tenantRelationshipName(fn () => 'organization')
            ->tenantOwnershipRelationshipName(fn () => 'company');

        MockResource::setPlugin($plugin);

        expect(MockResource::isScopedToTenant())->toBeTrue()
            ->and(MockResource::getTenantRelationshipName())->toBe('organization')
            ->and(MockResource::getTenantOwnershipRelationshipName())->toBe('company');
    });
});
