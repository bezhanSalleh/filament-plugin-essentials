<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\RegressionTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\NullOverrideTestUserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Explicit null overrides (issue #20)', function () {
    it('applies the plugin default icon when the user sets nothing', function () {
        $this->panel->plugins([
            RegressionTestPlugin::make(),
        ]);

        expect(NullOverrideTestUserResource::getNavigationIcon())->toBe('heroicon-o-cog');
    });

    it('clears the plugin default icon when the user passes an explicit null', function () {
        $this->panel->plugins([
            RegressionTestPlugin::make()->navigationIcon(null),
        ]);

        expect(NullOverrideTestUserResource::getNavigationIcon())->toBeNull();
    });

    it('clears the plugin default icon per-resource via forResource()', function () {
        $this->panel->plugins([
            RegressionTestPlugin::make()
                ->forResource(NullOverrideTestUserResource::class)
                ->navigationIcon(null),
        ]);

        expect(NullOverrideTestUserResource::getNavigationIcon())->toBeNull();
    });
});
