<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

it('can register the plugin', function () {
    $this->panel
        ->plugins([
            EssentialPlugin::make(),
        ]);

    expect(Filament::getPlugin('bezhansalleh/essentials'))->toBeInstanceOf(CuratorPlugin::class);
});

it('sets model labels', function (
    string | Closure $label,
    string | Closure $pluralLabel,
) {
    $this->panel
        ->plugins([
            EssentialPlugin::make()
                ->modelLabel($label)
                ->pluralModelLabel($pluralLabel),
        ]);

    $instance = Filament::getPlugin('bezhansalleh/essentials');
    expect($instance->getModelLabel())->toBe('test')
        ->and($instance->getPluralModelLabel())->toBe('tests');
})->with([
    ['test', 'tests'],
    [fn () => 'test', fn () => 'tests'],
]);
