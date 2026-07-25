<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\TraitlessTestPlugin;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class NoSearchTraitTestUserResource extends Resource
{
    use HasGlobalSearch;
    use HasLabels;

    protected static ?string $model = User::class;

    public static function getEssentialsPlugin(): ?TraitlessTestPlugin
    {
        return TraitlessTestPlugin::get();
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
