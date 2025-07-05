<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Plugin;

use Closure;
use Filament\Clusters\Cluster;

trait BelongsToCluster
{
    /**
     * @var class-string<Cluster> | null
     */
    protected Closure | null | string $cluster = null;

    public function cluster(string | Closure | null $cluster): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('cluster', $cluster);
        }

        $this->cluster = $cluster;

        return $this;
    }

    /**
     * @return class-string<Cluster> | null
     */
    public function getCluster(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('cluster', $resourceClass);
        } else {
            $value = $this->cluster;
        }

        return $this->evaluate($value);
    }
}
