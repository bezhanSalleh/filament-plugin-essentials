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
        $this->cluster = $cluster;

        return $this;
    }

    /**
     * @return class-string<Cluster> | null
     */
    public function getCluster(): ?string
    {
        return $this->evaluate($this->cluster);
    }
}
