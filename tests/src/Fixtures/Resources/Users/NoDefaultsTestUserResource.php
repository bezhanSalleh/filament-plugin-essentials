<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\NoDefaultsTestPlugin;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NoDefaultsTestUserResource extends Resource
{
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getEssentialsPlugin(): ?NoDefaultsTestPlugin
    {
        return NoDefaultsTestPlugin::get();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [];
    }
}
