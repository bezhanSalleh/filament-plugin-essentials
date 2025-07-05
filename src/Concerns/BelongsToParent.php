<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns;

trait BelongsToParent
{
    /**
     * @var class-string | null
     */
    protected ?string $parentResource = null;

    public function parentResource(?string $resource): static
    {
        $this->parentResource = $resource;

        return $this;
    }

    /**
     * @return class-string | null
     */
    public function getParentResource(): ?string
    {
        return $this->parentResource;
    }
}
