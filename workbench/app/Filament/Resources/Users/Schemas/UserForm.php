<?php

namespace Workbench\App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('filament-plugin-essentials::resources.users.schemas.user-form.name.label'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->unique(ignoreRecord: true)
                    ->required(),
            ]);
    }
}
