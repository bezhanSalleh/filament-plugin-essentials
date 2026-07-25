<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

use BackedEnum;
use Closure;
use Filament\Pages\Enums\SubNavigationPosition;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;

trait HasNavigation
{
    use HasPluginDefaults;

    protected Closure | null | SubNavigationPosition $subNavigationPosition = null;

    protected bool | Closure $shouldRegisterNavigation = true;

    protected Closure | null | string $navigationBadgeTooltip = null;

    protected Closure | null | string | UnitEnum $navigationGroup = null;

    protected array | Closure | null | string $navigationBadgeColor = null;

    protected Closure | string | null $navigationBadge = null;

    protected Closure | string | null $navigationParentItem = null;

    protected BackedEnum | Closure | null | string $navigationIcon = null;

    protected BackedEnum | Closure | null | string $activeNavigationIcon = null;

    protected Closure | null | string $navigationLabel = null;

    protected Closure | int | null $navigationSort = null;

    public function subNavigationPosition(Closure | SubNavigationPosition $subNavigationPosition): static
    {
        return $this->fillEssentialsProperty('subNavigationPosition', $subNavigationPosition);
    }

    public function registerNavigation(bool | Closure $shouldRegisterNavigation): static
    {
        return $this->fillEssentialsProperty('shouldRegisterNavigation', $shouldRegisterNavigation);
    }

    public function navigationBadgeTooltip(string | Closure | null $tooltip): static
    {
        return $this->fillEssentialsProperty('navigationBadgeTooltip', $tooltip);
    }

    public function navigationBadge(Closure | null | string $value = null): static
    {
        return $this->fillEssentialsProperty('navigationBadge', $value);
    }

    public function navigationBadgeColor(array | Closure | string $color): static
    {
        return $this->fillEssentialsProperty('navigationBadgeColor', $color);
    }

    public function navigationGroup(Closure | null | string | UnitEnum $group): static
    {
        return $this->fillEssentialsProperty('navigationGroup', $group);
    }

    public function navigationParentItem(string | Closure | null $item): static
    {
        return $this->fillEssentialsProperty('navigationParentItem', $item);
    }

    public function navigationIcon(BackedEnum | Closure | null | string $icon): static
    {
        return $this->fillEssentialsProperty('navigationIcon', $icon);
    }

    public function activeNavigationIcon(BackedEnum | Closure | null | string $icon): static
    {
        return $this->fillEssentialsProperty('activeNavigationIcon', $icon);
    }

    public function navigationLabel(Closure | null | string $label): static
    {
        return $this->fillEssentialsProperty('navigationLabel', $label);
    }

    public function navigationSort(int | Closure | null $sort): static
    {
        return $this->fillEssentialsProperty('navigationSort', $sort);
    }

    public function getSubNavigationPosition(?string $resourceClass = null): SubNavigationPosition
    {
        return $this->getPropertyWithDefaults('subNavigationPosition', $resourceClass) ?? SubNavigationPosition::Start;
    }

    public function shouldRegisterNavigation(?string $resourceClass = null): bool
    {
        return $this->getPropertyWithDefaults('shouldRegisterNavigation', $resourceClass) ?? true;
    }

    public function getNavigationBadgeTooltip(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('navigationBadgeTooltip', $resourceClass);
    }

    public function getNavigationBadge(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('navigationBadge', $resourceClass);
    }

    public function getNavigationBadgeColor(?string $resourceClass = null): array | string | null
    {
        return $this->getPropertyWithDefaults('navigationBadgeColor', $resourceClass);
    }

    public function getNavigationGroup(?string $resourceClass = null): string | UnitEnum | null
    {
        return $this->getPropertyWithDefaults('navigationGroup', $resourceClass);
    }

    public function getNavigationParentItem(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('navigationParentItem', $resourceClass);
    }

    public function getNavigationIcon(?string $resourceClass = null): BackedEnum | Htmlable | null | string
    {
        return $this->getPropertyWithDefaults('navigationIcon', $resourceClass);
    }

    public function getActiveNavigationIcon(?string $resourceClass = null): BackedEnum | Htmlable | null | string
    {
        return $this->getPropertyWithDefaults('activeNavigationIcon', $resourceClass);
    }

    public function getNavigationLabel(?string $resourceClass = null): string
    {
        return (string) $this->getPropertyWithDefaults('navigationLabel', $resourceClass);
    }

    public function getNavigationSort(?string $resourceClass = null): ?int
    {
        return $this->getPropertyWithDefaults('navigationSort', $resourceClass);
    }
}
