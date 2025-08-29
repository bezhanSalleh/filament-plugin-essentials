<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToParent;
use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToTenant;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\FullFeaturesTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\Pages\CreateUser;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\Pages\EditUser;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\Pages\ListUsers;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\Pages\ViewUser;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\Schemas\UserForm;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\Schemas\UserInfolist;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\Tables\UsersTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UserResource extends Resource
{
    // use BelongsToParent;
    use BelongsToTenant;
    // use HasGlobalSearch;
    // use HasLabels;
    // use HasNavigation;

    protected static ?string $model = User::class;

    public static function getEssentialsPlugin(): ?FullFeaturesTestPlugin
    {
        return FullFeaturesTestPlugin::get();
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
