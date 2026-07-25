<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\InheritedTraitTestPlugin;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class InheritedTraitTestUserResource extends Resource
{
    use HasLabels;

    protected static ?string $model = User::class;

    public static function getEssentialsPlugin(): ?InheritedTraitTestPlugin
    {
        return InheritedTraitTestPlugin::get();
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
