<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

use Closure;

trait HasLabels
{
    use HasPluginDefaults;

    protected string | Closure | null $modelLabel = null;

    protected string | Closure | null $pluralModelLabel = null;

    protected string | Closure | null $recordTitleAttribute = null;

    protected bool | Closure $hasTitleCaseModelLabel = true;

    public function modelLabel(string | Closure | null $label): static
    {
        return $this->fillEssentialsProperty('modelLabel', $label);
    }

    public function pluralModelLabel(string | Closure | null $label): static
    {
        return $this->fillEssentialsProperty('pluralModelLabel', $label);
    }

    public function titleCaseModelLabel(bool | Closure $condition = true): static
    {
        return $this->fillEssentialsProperty('hasTitleCaseModelLabel', $condition);
    }

    public function recordTitleAttribute(string | Closure | null $attribute): static
    {
        return $this->fillEssentialsProperty('recordTitleAttribute', $attribute);
    }

    public function getModelLabel(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('modelLabel', $resourceClass);
    }

    public function getPluralModelLabel(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('pluralModelLabel', $resourceClass);
    }

    public function hasTitleCaseModelLabel(?string $resourceClass = null): bool
    {
        return $this->getPropertyWithDefaults('hasTitleCaseModelLabel', $resourceClass) ?? true;
    }

    public function getRecordTitleAttribute(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('recordTitleAttribute', $resourceClass);
    }
}
