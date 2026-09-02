<?php

namespace App\Filament\Resources\TrialOptionResource\Pages;

use App\Filament\Resources\TrialOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrialOption extends EditRecord
{
    protected static string $resource = TrialOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
