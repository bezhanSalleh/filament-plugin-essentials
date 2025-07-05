<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

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

/**
 * Full-featured plugin for testing all traits together
 */
class FullFeaturesTestPlugin implements Plugin
{
    use BelongsToCluster;
    use BelongsToParent;
    use BelongsToTenant;
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected function getPluginDefaults(): array
    {
        return [
            // HasLabels
            'modelLabel' => 'Full Item',
            'pluralModelLabel' => 'Full Items',
            'recordTitleAttribute' => 'title',
            'hasTitleCaseModelLabel' => false,

            // HasNavigation
            'navigationLabel' => 'Full Nav',
            'navigationSort' => 10,
            'shouldRegisterNavigation' => true,
            'navigationGroup' => 'Full Group',

            // HasGlobalSearch
            'globalSearchResultsLimit' => 25,
            'isGloballySearchable' => true,
            'shouldSplitGlobalSearchTerms' => false,

            // BelongsToCluster
            'cluster' => 'FullCluster',

            // BelongsToParent
            'parentResource' => 'FullParentResource',

            // BelongsToTenant
            'isScopedToTenant' => true,
            'tenantRelationshipName' => 'organization',
            'tenantOwnershipRelationshipName' => 'owner',
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('full-features-test');
    }

    public function getId(): string
    {
        return 'full-features-test';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
