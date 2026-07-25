<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\BasicTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\ContextualProbeTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\LegacyApiProbeUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\NullOverrideTestUserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Legacy delegation API stays backward compatible', function () {
    it('delegateToPlugin still returns plugin values', function () {
        $this->panel->plugins([
            BasicTestPlugin::make(),
        ]);

        expect(LegacyApiProbeUserResource::probeDelegate('HasLabels', 'getModelLabel'))->toBe('Basic Item');
    });

    it('delegateToPlugin still returns the sentinel when the plugin lacks the trait', function () {
        $this->panel->plugins([
            BasicTestPlugin::make(),
        ]);

        $result = LegacyApiProbeUserResource::probeDelegate('HasNavigation', 'getNavigationIcon');

        expect(LegacyApiProbeUserResource::probeIsNoPluginResult($result))->toBeTrue();
    });

    it('getParentResult still resolves the Filament parent method', function () {
        expect(LegacyApiProbeUserResource::probeParentResult('getModelLabel'))->toBe('user');
    });

    it('pluginUsesTrait still answers for direct trait usage', function () {
        $plugin = BasicTestPlugin::make();

        expect(LegacyApiProbeUserResource::pluginUsesTrait($plugin, 'HasLabels'))->toBeTrue()
            ->and(LegacyApiProbeUserResource::pluginUsesTrait($plugin, 'HasNavigation'))->toBeFalse();
    });

    it('getContextualProperty still reads scoped and global user values', function () {
        $plugin = ContextualProbeTestPlugin::make()
            ->forResource(NullOverrideTestUserResource::class)
            ->navigationLabel('Scoped Label');

        expect($plugin->probeGetContextualProperty('navigationLabel', NullOverrideTestUserResource::class))->toBe('Scoped Label')
            ->and($plugin->probeGetContextualProperty('navigationLabel'))->toBeNull();
    });
});
