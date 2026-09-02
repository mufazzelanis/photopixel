<?php

namespace App\Filament\Resources\WorkSampleResource\Pages;

use App\Filament\Resources\WorkSampleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkSamples extends ListRecords
{
    protected static string $resource = WorkSampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
