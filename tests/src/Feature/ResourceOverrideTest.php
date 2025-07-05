<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
});

it('delegates to plugin when plugin uses same trait', function () {
    $plugin = new MockPlugin;
    $plugin->navigationLabel('Plugin Label')
        ->navigationIcon('heroicon-s-sparkles')
        ->navigationGroup('Plugin Group')
        ->navigationSort(5);

    MockResource::setPlugin($plugin);

    expect(MockResource::getNavigationLabel())->toBe('Plugin Label')
        ->and(MockResource::getNavigationIcon())->toBe('heroicon-s-sparkles')
        ->and(MockResource::getNavigationGroup())->toBe('Plugin Group')
        ->and(MockResource::getNavigationSort())->toBe(5);
});

it('falls back to parent when no plugin is set', function () {
    expect(MockResource::getNavigationLabel())->toBe('Default Label')
        ->and(MockResource::getNavigationIcon())->toBe('heroicon-o-home')
        ->and(MockResource::getNavigationGroup())->toBe('Default Group')
        ->and(MockResource::getNavigationSort())->toBe(1);
});

it('handles navigation badge correctly', function () {
    $plugin = new MockPlugin;
    $plugin->navigationBadge('5');

    MockResource::setPlugin($plugin);

    expect(MockResource::getNavigationBadge())->toBe('5');
});

it('handles navigation badge tooltip correctly', function () {
    $plugin = new MockPlugin;
    $plugin->navigationBadgeTooltip('New items available');

    MockResource::setPlugin($plugin);

    expect(MockResource::getNavigationBadgeTooltip())->toBe('New items available');
});

it('handles labels correctly', function () {
    $plugin = new MockPlugin;
    $plugin->modelLabel('Custom Model')
        ->pluralModelLabel('Custom Models');

    MockResource::setPlugin($plugin);

    expect(MockResource::getModelLabel())->toBe('Custom Model')
        ->and(MockResource::getPluralModelLabel())->toBe('Custom Models');
});

it('handles cluster correctly', function () {
    $plugin = new MockPlugin;
    $plugin->cluster('App\\Clusters\\MyCluster');

    MockResource::setPlugin($plugin);

    expect(MockResource::getCluster())->toBe('App\\Clusters\\MyCluster');
});

it('handles closure values correctly', function () {
    $plugin = new MockPlugin;
    $plugin->navigationLabel(fn () => 'Dynamic Label')
        ->navigationIcon(fn () => 'heroicon-s-dynamic');

    MockResource::setPlugin($plugin);

    expect(MockResource::getNavigationLabel())->toBe('Dynamic Label')
        ->and(MockResource::getNavigationIcon())->toBe('heroicon-s-dynamic');
});

it('handles null values correctly', function () {
    $plugin = new MockPlugin;
    $plugin->navigationLabel(null)
        ->navigationIcon(null);

    MockResource::setPlugin($plugin);

    expect(MockResource::getNavigationLabel())->toBe('')
        ->and(MockResource::getNavigationIcon())->toBeNull();
});

it('returns correct defaults for boolean methods', function () {
    $plugin = new MockPlugin;
    MockResource::setPlugin($plugin);

    expect(MockResource::shouldRegisterNavigation())->toBeTrue();
});

it('handles boolean configuration correctly', function () {
    $plugin = new MockPlugin;
    $plugin->registerNavigation(false);

    MockResource::setPlugin($plugin);

    expect(MockResource::shouldRegisterNavigation())->toBeFalse();
});
