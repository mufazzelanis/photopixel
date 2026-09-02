<?php

namespace App\Filament\Resources\AboutPartnershipPointResource\Pages;

use App\Filament\Resources\AboutPartnershipPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutPartnershipPoint extends EditRecord
{
    protected static string $resource = AboutPartnershipPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
