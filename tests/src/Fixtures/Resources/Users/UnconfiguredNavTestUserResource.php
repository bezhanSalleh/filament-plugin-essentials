<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BackedEnum;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\UnconfiguredTestPlugin;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UnconfiguredNavTestUserResource extends Resource
{
    use HasGlobalSearch;
    use HasNavigation;

    protected static ?string $model = User::class;

    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-star';

    protected static ?int $navigationSort = 7;

    protected static bool $shouldRegisterNavigation = false;

    protected static int $globalSearchResultsLimit = 10;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEssentialsPlugin(): ?UnconfiguredTestPlugin
    {
        return UnconfiguredTestPlugin::get();
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
