<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

trait BelongsToParent
{
    use HasPluginDefaults;

    /**
     * @var class-string | null
     */
    protected ?string $parentResource = null;

    public function parentResource(?string $resource): static
    {
        return $this->fillEssentialsProperty('parentResource', $resource);
    }

    /**
     * @return class-string | null
     */
    public function getParentResource(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('parentResource', $resourceClass);
    }
}
