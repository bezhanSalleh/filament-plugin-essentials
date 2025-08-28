<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts;

use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToParent;
use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToTenant;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\MultiResourceTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\Pages\ManagePosts;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostResource extends Resource
{
    use BelongsToParent;
    use BelongsToTenant;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = Post::class;

    public static function getEssentialsPlugin(): ?MultiResourceTestPlugin
    {
        return MultiResourceTestPlugin::get();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('tenant_id'),
                RichEditor::make('body')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tenant_id')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePosts::route('/'),
        ];
    }
}
