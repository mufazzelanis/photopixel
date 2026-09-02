<?php

namespace App\Filament\Resources\ValueCardResource\Pages;

use App\Filament\Resources\ValueCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValueCard extends EditRecord
{
    protected static string $resource = ValueCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
