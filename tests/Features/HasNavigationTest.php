<?php

use BezhanSalleh\PluginEssentials\Concerns\HasNavigation;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Concerns\EvaluatesClosures;

beforeEach(function () {
    $this->testClass = new class
    {
        use EvaluatesClosures;
        use HasNavigation;
    };
});

it('can set sub navigation position as enum', function () {
    $position = SubNavigationPosition::Top;

    $result = $this->testClass->subNavigationPosition($position);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getSubNavigationPosition())->toBe($position);
});

it('can set sub navigation position as closure', function () {
    $position = SubNavigationPosition::Top;

    $result = $this->testClass->subNavigationPosition(fn () => $position);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getSubNavigationPosition())->toBe($position);
});

it('can set register navigation as boolean', function () {
    $result = $this->testClass->registerNavigation(false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->shouldRegisterNavigation())->toBeFalse();
});

it('can set register navigation as closure', function () {
    $result = $this->testClass->registerNavigation(fn () => false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->shouldRegisterNavigation())->toBeFalse();
});

it('has default true register navigation', function () {
    expect($this->testClass->shouldRegisterNavigation())->toBeTrue();
});

it('can set navigation badge tooltip as string', function () {
    $tooltip = 'Test tooltip';

    $result = $this->testClass->navigationBadgeTooltip($tooltip);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationBadgeTooltip())->toBe($tooltip);
});

it('can set navigation badge tooltip as closure', function () {
    $tooltip = 'Test tooltip';

    $result = $this->testClass->navigationBadgeTooltip(fn () => $tooltip);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationBadgeTooltip())->toBe($tooltip);
});

it('can set navigation badge tooltip as null', function () {
    $result = $this->testClass->navigationBadgeTooltip(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationBadgeTooltip())->toBeNull();
});

it('has default null navigation badge tooltip', function () {
    expect($this->testClass->getNavigationBadgeTooltip())->toBeNull();
});

it('can set navigation badge as boolean', function () {
    $result = $this->testClass->navigationBadge(true);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->shouldEnableNavigationBadge())->toBeTrue();
});

it('can set navigation badge as closure', function () {
    $result = $this->testClass->navigationBadge(fn () => true);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->shouldEnableNavigationBadge())->toBeTrue();
});

it('has default false navigation badge', function () {
    expect($this->testClass->shouldEnableNavigationBadge())->toBeFalse();
});

it('can set navigation badge color as string', function () {
    $color = 'primary';

    $result = $this->testClass->navigationBadgeColor($color);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationBadgeColor())->toBe($color);
});

it('can set navigation badge color as array', function () {
    $color = ['primary', 'secondary'];

    $result = $this->testClass->navigationBadgeColor($color);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationBadgeColor())->toBe($color);
});

it('can set navigation badge color as closure', function () {
    $color = 'primary';

    $result = $this->testClass->navigationBadgeColor(fn () => $color);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationBadgeColor())->toBe($color);
});

it('can set navigation group as string', function () {
    $group = 'Administration';

    $result = $this->testClass->navigationGroup($group);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationGroup())->toBe($group);
});

it('can set navigation group as closure', function () {
    $group = 'Administration';

    $result = $this->testClass->navigationGroup(fn () => $group);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationGroup())->toBe($group);
});

it('can set navigation group as null', function () {
    $result = $this->testClass->navigationGroup(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationGroup())->toBeNull();
});

it('can set navigation parent item as string', function () {
    $item = 'Settings';

    $result = $this->testClass->navigationParentItem($item);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationParentItem())->toBe($item);
});

it('can set navigation parent item as closure', function () {
    $item = 'Settings';

    $result = $this->testClass->navigationParentItem(fn () => $item);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationParentItem())->toBe($item);
});

it('can set navigation parent item as null', function () {
    $result = $this->testClass->navigationParentItem(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationParentItem())->toBeNull();
});

it('can set navigation icon as string', function () {
    $icon = 'heroicon-o-users';

    $result = $this->testClass->navigationIcon($icon);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationIcon())->toBe($icon);
});

it('can set navigation icon as closure', function () {
    $icon = 'heroicon-o-users';

    $result = $this->testClass->navigationIcon(fn () => $icon);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationIcon())->toBe($icon);
});

it('can set navigation icon as null', function () {
    $result = $this->testClass->navigationIcon(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationIcon())->toBeNull();
});

it('can set active navigation icon as string', function () {
    $icon = 'heroicon-s-users';

    $result = $this->testClass->activeNavigationIcon($icon);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getActiveNavigationIcon())->toBe($icon);
});

it('can set active navigation icon as closure', function () {
    $icon = 'heroicon-s-users';

    $result = $this->testClass->activeNavigationIcon(fn () => $icon);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getActiveNavigationIcon())->toBe($icon);
});

it('can set active navigation icon as null', function () {
    $result = $this->testClass->activeNavigationIcon(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getActiveNavigationIcon())->toBeNull();
});

it('can set navigation label as string', function () {
    $label = 'Users';

    $result = $this->testClass->navigationLabel($label);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationLabel())->toBe($label);
});

it('can set navigation label as closure', function () {
    $label = 'Users';

    $result = $this->testClass->navigationLabel(fn () => $label);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationLabel())->toBe($label);
});

it('can set navigation label as null', function () {
    $result = $this->testClass->navigationLabel(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationLabel())->toBe('');
});

it('can set navigation sort as integer', function () {
    $sort = 10;

    $result = $this->testClass->navigationSort($sort);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationSort())->toBe($sort);
});

it('can set navigation sort as closure', function () {
    $sort = 10;

    $result = $this->testClass->navigationSort(fn () => $sort);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationSort())->toBe($sort);
});

it('can set navigation sort as null', function () {
    $result = $this->testClass->navigationSort(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationSort())->toBeNull();
});

it('can set slug as string', function () {
    $slug = 'users';

    $result = $this->testClass->slug($slug);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getSlug())->toBe($slug);
});

it('can set slug as closure', function () {
    $slug = 'users';

    $result = $this->testClass->slug(fn () => $slug);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getSlug())->toBe($slug);
});

it('can set slug as null', function () {
    $result = $this->testClass->slug(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getSlug())->toBeNull();
});

it('evaluates closures properly', function () {
    $called = false;

    $this->testClass->navigationLabel(function () use (&$called) {
        $called = true;

        return 'Test Label';
    });

    $result = $this->testClass->getNavigationLabel();

    expect($called)->toBeTrue()
        ->and($result)->toBe('Test Label');
});

it('returns fluent interface for all methods', function () {
    expect($this->testClass->registerNavigation(false))->toBe($this->testClass)
        ->and($this->testClass->navigationBadgeTooltip('Test'))->toBe($this->testClass)
        ->and($this->testClass->navigationBadge(true))->toBe($this->testClass)
        ->and($this->testClass->navigationBadgeColor('primary'))->toBe($this->testClass)
        ->and($this->testClass->navigationGroup('Admin'))->toBe($this->testClass)
        ->and($this->testClass->navigationParentItem('Settings'))->toBe($this->testClass)
        ->and($this->testClass->navigationIcon('heroicon-o-users'))->toBe($this->testClass)
        ->and($this->testClass->activeNavigationIcon('heroicon-s-users'))->toBe($this->testClass)
        ->and($this->testClass->navigationLabel('Users'))->toBe($this->testClass)
        ->and($this->testClass->navigationSort(10))->toBe($this->testClass)
        ->and($this->testClass->slug('users'))->toBe($this->testClass);
});

it('can chain multiple methods', function () {
    $result = $this->testClass
        ->navigationLabel('Posts')
        ->navigationIcon('heroicon-o-document-text')
        ->navigationGroup('Content')
        ->navigationSort(5)
        ->slug('posts');

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getNavigationLabel())->toBe('Posts')
        ->and($this->testClass->getNavigationIcon())->toBe('heroicon-o-document-text')
        ->and($this->testClass->getNavigationGroup())->toBe('Content')
        ->and($this->testClass->getNavigationSort())->toBe(5)
        ->and($this->testClass->getSlug())->toBe('posts');
});
