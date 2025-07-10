<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

use Closure;
use Filament\Clusters\Cluster;

trait BelongsToCluster
{
    use HasPluginDefaults;

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
        $this->markPropertyAsUserSet('cluster');

        return $this;
    }

    /**
     * @return class-string<Cluster> | null
     */
    public function getCluster(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('cluster', $resourceClass);
    }
}
