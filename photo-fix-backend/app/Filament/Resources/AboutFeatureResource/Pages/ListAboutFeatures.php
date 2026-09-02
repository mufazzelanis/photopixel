<?php

namespace App\Filament\Resources\AboutFeatureResource\Pages;

use App\Filament\Resources\AboutFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutFeatures extends ListRecords
{
    protected static string $resource = AboutFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
