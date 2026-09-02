<?php

namespace App\Filament\Resources\WhyPointResource\Pages;

use App\Filament\Resources\WhyPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhyPoint extends EditRecord
{
    protected static string $resource = WhyPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
