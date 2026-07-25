<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\RegressionTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\TraitlessTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\UnconfiguredTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\AttrlessSearchTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\NoSearchTraitTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\OptedOutSearchTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\TitledSearchTestUserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Global search gating (Filament parity)', function () {
    it('allows search when the plugin enables it and the resource has a title attribute', function () {
        $this->panel->plugins([
            RegressionTestPlugin::make()->globallySearchable(true),
        ]);

        expect(TitledSearchTestUserResource::canGloballySearch())->toBeTrue();
    });

    it('gates search off when the resource has no searchable attributes, even if the plugin enables it', function () {
        $this->panel->plugins([
            RegressionTestPlugin::make()->globallySearchable(true),
        ]);

        expect(AttrlessSearchTestUserResource::canGloballySearch())->toBeFalse();
    });

    it('disables search when the plugin disables it', function () {
        $this->panel->plugins([
            RegressionTestPlugin::make()->globallySearchable(false),
        ]);

        expect(TitledSearchTestUserResource::canGloballySearch())->toBeFalse();
    });

    it('respects a resource-level opt-out when the plugin is silent', function () {
        $this->panel->plugins([
            UnconfiguredTestPlugin::make(),
        ]);

        expect(OptedOutSearchTestUserResource::canGloballySearch())->toBeFalse();
    });

    it('falls back to the static property without a TypeError when the plugin lacks the trait', function () {
        $this->panel->plugins([
            TraitlessTestPlugin::make(),
        ]);

        expect(NoSearchTraitTestUserResource::isGloballySearchable())->toBeTrue();
    });
});
