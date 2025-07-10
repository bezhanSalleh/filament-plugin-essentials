<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BackedEnum;
use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToCluster;
use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToParent;
use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToTenant;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\FullFeaturesTestPlugin;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FullFeaturesTestUserResource extends Resource
{
    use BelongsToCluster;
    use BelongsToParent;
    use BelongsToTenant;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = User::class;

    protected static BackedEnum | string | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function pluginEssential(): ?FullFeaturesTestPlugin
    {
        return FullFeaturesTestPlugin::get();
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
