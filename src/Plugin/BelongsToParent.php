<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Plugin;

trait BelongsToParent
{
    /**
     * @var class-string | null
     */
    protected ?string $parentResource = null;

    public function parentResource(?string $resource): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('parentResource', $resource);
        }

        $this->parentResource = $resource;

        return $this;
    }

    /**
     * @return class-string | null
     */
    public function getParentResource(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            return $this->getContextualProperty('parentResource', $resourceClass);
        }

        return $this->parentResource;
    }
}
