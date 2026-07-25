<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

use Closure;

trait HasGlobalSearch
{
    use HasPluginDefaults;

    protected int $globalSearchResultsLimit = 50;

    protected bool | Closure $isGloballySearchable = true;

    protected bool | Closure | null $isGlobalSearchForcedCaseInsensitive = null;

    protected bool | Closure $shouldSplitGlobalSearchTerms = false;

    public function globalSearchResultsLimit(int $limit): static
    {
        return $this->fillEssentialsProperty('globalSearchResultsLimit', $limit);
    }

    public function globallySearchable(bool | Closure $condition = true): static
    {
        return $this->fillEssentialsProperty('isGloballySearchable', $condition);
    }

    public function forceGlobalSearchCaseInsensitive(bool | Closure | null $condition = true): static
    {
        return $this->fillEssentialsProperty('isGlobalSearchForcedCaseInsensitive', $condition);
    }

    public function splitGlobalSearchTerms(bool | Closure $condition = true): static
    {
        return $this->fillEssentialsProperty('shouldSplitGlobalSearchTerms', $condition);
    }

    public function isGloballySearchable(?string $resourceClass = null): bool
    {
        return $this->getPropertyWithDefaults('isGloballySearchable', $resourceClass) ?? true;
    }

    public function canGloballySearch(?string $resourceClass = null): bool
    {
        return $this->getPropertyWithDefaults('isGloballySearchable', $resourceClass) ?? true;
    }

    public function getGlobalSearchResultsLimit(?string $resourceClass = null): int
    {
        return $this->getPropertyWithDefaults('globalSearchResultsLimit', $resourceClass) ?? 50;
    }

    public function isGlobalSearchForcedCaseInsensitive(?string $resourceClass = null): ?bool
    {
        return $this->getPropertyWithDefaults('isGlobalSearchForcedCaseInsensitive', $resourceClass);
    }

    public function shouldSplitGlobalSearchTerms(?string $resourceClass = null): bool
    {
        return $this->getPropertyWithDefaults('shouldSplitGlobalSearchTerms', $resourceClass) ?? false;
    }
}
