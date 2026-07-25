<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BackedEnum;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\RegressionTestPlugin;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class NullOverrideTestUserResource extends Resource
{
    use HasNavigation;

    protected static ?string $model = User::class;

    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-star';

    public static function getEssentialsPlugin(): ?RegressionTestPlugin
    {
        return RegressionTestPlugin::get();
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
