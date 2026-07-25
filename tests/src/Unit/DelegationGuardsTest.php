<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\InheritedTraitTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\TraitlessTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\InheritedTraitTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\NoPluginMethodTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\NoSearchTraitTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\ThrowingPluginTestUserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Delegation guard rails', function () {
    it('falls back to parent when the resource defines no getEssentialsPlugin()', function () {
        expect(NoPluginMethodTestUserResource::getModelLabel())->toBe('user');
    });

    it('falls back to parent when getEssentialsPlugin() throws', function () {
        expect(ThrowingPluginTestUserResource::getModelLabel())->toBe('user');
    });

    it('falls back to parent when the plugin lacks the delegated trait', function () {
        $this->panel->plugins([
            TraitlessTestPlugin::make(),
        ]);

        expect(NoSearchTraitTestUserResource::getModelLabel())->toBe('user');
    });

    it('delegates when the plugin inherits the trait from an abstract base class', function () {
        $this->panel->plugins([
            InheritedTraitTestPlugin::make(),
        ]);

        expect(InheritedTraitTestUserResource::getModelLabel())->toBe('Inherited Label');
    });
});
