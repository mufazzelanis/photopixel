<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Drop into any Resource to make it show up in the admin's global search
 * (Ctrl/Cmd+K). Optionally declare on the resource:
 *
 *   protected static array $globalSearch = ['name', 'email'];         // columns matched
 *   protected static array $globalSearchDetails = ['Email' => 'email']; // label => attr shown per hit
 *
 * With neither, it searches the resource's record-title column.
 */
trait GloballySearchable
{
    protected static function globalSearchColumns(): array
    {
        if (property_exists(static::class, 'globalSearch') && ! empty(static::$globalSearch)) {
            return static::$globalSearch;
        }

        return array_values(array_filter([static::getRecordTitleAttribute()]));
    }

    protected static function globalSearchDetailMap(): array
    {
        return property_exists(static::class, 'globalSearchDetails')
            ? static::$globalSearchDetails
            : [];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return static::globalSearchColumns();
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        $attr = static::getRecordTitleAttribute();
        $title = $attr ? (string) data_get($record, $attr) : '';

        return $title !== '' ? $title : class_basename($record).' #'.$record->getKey();
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        foreach (static::globalSearchDetailMap() as $label => $attribute) {
            $value = data_get($record, $attribute);
            if (filled($value)) {
                $details[$label] = \Illuminate\Support\Str::limit(strip_tags((string) $value), 70);
            }
        }

        if (empty($details) && ($group = static::getNavigationGroup())) {
            $details['Section'] = $group;
        }

        return $details;
    }

    public static function getGlobalSearchResultUrl(Model $record): ?string
    {
        if (static::hasPage('edit') && static::canEdit($record)) {
            return static::getUrl('edit', ['record' => $record]);
        }

        if (static::hasPage('view') && static::canView($record)) {
            return static::getUrl('view', ['record' => $record]);
        }

        return static::getUrl('index');
    }
}
