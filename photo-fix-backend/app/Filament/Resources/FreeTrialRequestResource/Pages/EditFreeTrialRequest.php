<?php

namespace App\Filament\Resources\FreeTrialRequestResource\Pages;

use App\Filament\Resources\FreeTrialRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreeTrialRequest extends EditRecord
{
    protected static string $resource = FreeTrialRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
