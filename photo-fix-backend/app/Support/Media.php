<?php

namespace App\Support;

use Spatie\MediaLibrary\HasMedia;

class Media
{
    /**
     * Absolute URL for the first media in a collection (optionally a conversion),
     * or null when nothing has been uploaded yet.
     */
    public static function url(?HasMedia $model, string $collection, string $conversion = ''): ?string
    {
        if (! $model) {
            return null;
        }

        $media = $model->getFirstMedia($collection);

        if (! $media) {
            return null;
        }

        if ($conversion !== '' && $media->hasGeneratedConversion($conversion)) {
            return $media->getFullUrl($conversion);
        }

        return $media->getFullUrl();
    }

    /**
     * Every media in a collection as [{url, thumb, alt}].
     */
    public static function collection(?HasMedia $model, string $collection, string $conversion = 'web'): array
    {
        if (! $model) {
            return [];
        }

        return $model->getMedia($collection)->map(fn ($media) => [
            'url' => $media->getFullUrl(),
            'thumb' => $media->hasGeneratedConversion($conversion)
                ? $media->getFullUrl($conversion)
                : $media->getFullUrl(),
            'alt' => $media->getCustomProperty('alt', $media->name),
        ])->all();
    }
}
