<?php

namespace App\Filament\Resources\WorkSampleCategoryResource\Pages;

use App\Filament\Resources\WorkSampleCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkSampleCategory extends EditRecord
{
    protected static string $resource = WorkSampleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
