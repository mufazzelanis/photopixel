<?php

namespace App\Filament\Resources\AboutFeatureResource\Pages;

use App\Filament\Resources\AboutFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutFeature extends EditRecord
{
    protected static string $resource = AboutFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
