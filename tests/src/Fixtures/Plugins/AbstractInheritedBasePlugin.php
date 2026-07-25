<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use Filament\Contracts\Plugin;
use Filament\Support\Concerns\EvaluatesClosures;

abstract class AbstractInheritedBasePlugin implements Plugin
{
    use EvaluatesClosures;
    use HasLabels;

    protected function getPluginDefaults(): array
    {
        return [
            'modelLabel' => 'Inherited Label',
        ];
    }
}
