<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait HasLabels
{
    use DelegatesToPlugin;

    public static function getModelLabel(): string
    {
        return static::pluginOrParent('HasLabels', 'modelLabel', 'getModelLabel', nullFallsBack: true);
    }

    public static function getPluralModelLabel(): string
    {
        return static::pluginOrParent('HasLabels', 'pluralModelLabel', 'getPluralModelLabel', nullFallsBack: true);
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return static::pluginOrParent('HasLabels', 'recordTitleAttribute', 'getRecordTitleAttribute');
    }

    public static function hasTitleCaseModelLabel(): bool
    {
        return static::pluginOrParent('HasLabels', 'hasTitleCaseModelLabel', 'hasTitleCaseModelLabel', nullFallsBack: true);
    }
}
