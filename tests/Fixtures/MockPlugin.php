<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures;

use BezhanSalleh\PluginEssentials\Plugin;
use Filament\Support\Concerns\EvaluatesClosures;

class MockPlugin
{
    use EvaluatesClosures;
    use Plugin\BelongsToCluster;
    use Plugin\BelongsToParent;
    use Plugin\BelongsToTenant;
    use Plugin\HasGlobalSearch;
    use Plugin\HasLabels;
    use Plugin\HasNavigation;
}
