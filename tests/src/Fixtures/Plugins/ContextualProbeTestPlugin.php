<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use Filament\Facades\Filament;

class ContextualProbeTestPlugin extends RegressionTestPlugin
{
    public static function get(): ?static
    {
        return Filament::getPlugin('contextual-probe-test');
    }

    public function getId(): string
    {
        return 'contextual-probe-test';
    }

    public function probeGetContextualProperty(string $property, ?string $resourceClass = null): mixed
    {
        return $this->getContextualProperty($property, $resourceClass);
    }
}
