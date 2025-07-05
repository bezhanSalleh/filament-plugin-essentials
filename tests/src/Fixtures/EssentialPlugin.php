<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures;

use BezhanSalleh\PluginEssentials\Plugin\BelongsToCluster;
use BezhanSalleh\PluginEssentials\Plugin\BelongsToParent;
use BezhanSalleh\PluginEssentials\Plugin\BelongsToTenant;
use BezhanSalleh\PluginEssentials\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

class EssentialPlugin implements Plugin
{
    use BelongsToCluster;
    use BelongsToParent;
    use BelongsToTenant;
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    /**
     * Plugin developer defaults for testing
     */
    protected function getPluginDefaults(): array
    {
        return [
            'modelLabel' => 'Essential Item',
            'pluralModelLabel' => 'Essential Items',
            'recordTitleAttribute' => 'id',
            'hasTitleCaseModelLabel' => false,
        ];
    }

    /**
     * Alternative: Plugin developers can also override specific methods
     */
    protected function getDefaultModelLabel(?string $resourceClass = null): string
    {
        return 'Essential Item (Method)';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'bezhansalleh/essentials';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }

    public static function get(): Plugin
    {
        return filament(app(static::class)->getId());
    }
}
