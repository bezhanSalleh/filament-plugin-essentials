<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns;

use BackedEnum;
use Closure;
use Filament\Pages\Enums\SubNavigationPosition;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;

trait HasNavigation
{
    protected Closure | null | SubNavigationPosition $subNavigationPosition = null;

    protected bool | Closure $shouldRegisterNavigation = true;

    protected Closure | null | string $navigationBadgeTooltip = null;

    protected Closure | null | string | UnitEnum $navigationGroup = null;

    protected array | Closure | null | string $navigationBadgeColor = null;

    protected bool | Closure $shouldEnableNavigationBadge = false;

    protected Closure | string | null $navigationParentItem = null;

    protected BackedEnum | Closure | null | string $navigationIcon = null;

    protected BackedEnum | Closure | null | string $activeNavigationIcon = null;

    protected Closure | null | string $navigationLabel = null;

    protected Closure | int | null $navigationSort = null;

    protected Closure | null | string $slug = null;

    public function subNavigationPosition(Closure | SubNavigationPosition $subNavigationPosition): static
    {
        $this->subNavigationPosition = $subNavigationPosition;

        return $this;
    }

    public function registerNavigation(bool | Closure $shouldRegisterNavigation): static
    {
        $this->shouldRegisterNavigation = $shouldRegisterNavigation;

        return $this;
    }

    public function navigationBadgeTooltip(string | Closure | null $tooltip): static
    {
        $this->navigationBadgeTooltip = $tooltip;

        return $this;
    }

    public function navigationBadge(bool | Closure $condition = true): static
    {
        $this->shouldEnableNavigationBadge = $condition;

        return $this;
    }

    public function navigationBadgeColor(array | Closure | string $color): static
    {
        $this->navigationBadgeColor = $color;

        return $this;
    }

    public function navigationGroup(Closure | null | string | UnitEnum $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function navigationParentItem(string | Closure | null $item): static
    {
        $this->navigationParentItem = $item;

        return $this;
    }

    public function navigationIcon(BackedEnum | Closure | null | string $icon): static
    {
        $this->navigationIcon = $icon;

        return $this;
    }

    public function activeNavigationIcon(BackedEnum | Closure | null | string $icon): static
    {
        $this->activeNavigationIcon = $icon;

        return $this;
    }

    public function navigationLabel(Closure | null | string $label): static
    {
        $this->navigationLabel = $label;

        return $this;
    }

    public function navigationSort(int | Closure | null $sort): static
    {
        $this->navigationSort = $sort;

        return $this;
    }

    public function slug(string | Closure | null $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSubNavigationPosition(): SubNavigationPosition
    {
        return $this->evaluate($this->subNavigationPosition);
    }

    public function shouldRegisterNavigation(): bool
    {
        return $this->evaluate($this->shouldRegisterNavigation);
    }

    public function getNavigationBadgeTooltip(): ?string
    {
        return $this->evaluate($this->navigationBadgeTooltip);
    }

    public function shouldEnableNavigationBadge(): bool
    {
        return $this->evaluate($this->shouldEnableNavigationBadge);
    }

    public function getNavigationBadgeColor(): array | string | null
    {
        return $this->evaluate($this->navigationBadgeColor);
    }

    public function getNavigationGroup(): ?string
    {
        return $this->evaluate($this->navigationGroup);
    }

    public function getNavigationParentItem(): ?string
    {
        return $this->evaluate($this->navigationParentItem);
    }

    public function getNavigationIcon(): BackedEnum | Htmlable | null | string
    {
        return $this->evaluate($this->navigationIcon);
    }

    public function getActiveNavigationIcon(): BackedEnum | Htmlable | null | string
    {
        return $this->evaluate($this->activeNavigationIcon);
    }

    public function getNavigationLabel(): string
    {
        return (string) $this->evaluate($this->navigationLabel);
    }

    public function getNavigationSort(): ?int
    {
        return $this->evaluate($this->navigationSort);
    }

    public function getSlug(): ?string
    {
        return $this->evaluate($this->slug);
    }
}
