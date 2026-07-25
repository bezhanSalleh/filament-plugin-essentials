<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\UnconfiguredTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UnconfiguredNavTestUserResource;
use Filament\Facades\Filament;
use Filament\Pages\Enums\SubNavigationPosition;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();

    $this->panel->plugins([
        UnconfiguredTestPlugin::make(),
    ]);
});

describe('Tier-3 fallback: resource / Filament defaults win when the plugin is silent', function () {
    it('keeps the resource static navigation icon', function () {
        expect(UnconfiguredNavTestUserResource::getNavigationIcon())->toBe('heroicon-o-star');
    });

    it('keeps the resource static navigation sort', function () {
        expect(UnconfiguredNavTestUserResource::getNavigationSort())->toBe(7);
    });

    it('keeps the resource static shouldRegisterNavigation = false', function () {
        expect(UnconfiguredNavTestUserResource::shouldRegisterNavigation())->toBeFalse();
    });

    it('keeps the resource static global search results limit', function () {
        expect(UnconfiguredNavTestUserResource::getGlobalSearchResultsLimit())->toBe(10);
    });

    it('keeps Filament\'s native default of splitting global search terms', function () {
        expect(UnconfiguredNavTestUserResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });

    it('honors panel-level sub navigation position', function () {
        $this->panel->subNavigationPosition(SubNavigationPosition::End);

        expect(UnconfiguredNavTestUserResource::getSubNavigationPosition())
            ->toBe(SubNavigationPosition::End);
    });
});
