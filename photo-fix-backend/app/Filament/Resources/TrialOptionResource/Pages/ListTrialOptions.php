<?php

namespace App\Filament\Resources\TrialOptionResource\Pages;

use App\Filament\Resources\TrialOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrialOptions extends ListRecords
{
    protected static string $resource = TrialOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
