<?php

namespace App\Filament\Resources\WhyFeatureResource\Pages;

use App\Filament\Resources\WhyFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhyFeature extends EditRecord
{
    protected static string $resource = WhyFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
