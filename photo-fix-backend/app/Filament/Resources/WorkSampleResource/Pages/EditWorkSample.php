<?php

namespace App\Filament\Resources\WorkSampleResource\Pages;

use App\Filament\Resources\WorkSampleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkSample extends EditRecord
{
    protected static string $resource = WorkSampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
