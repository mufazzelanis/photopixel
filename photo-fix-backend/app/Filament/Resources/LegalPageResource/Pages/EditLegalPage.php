<?php

namespace App\Filament\Resources\LegalPageResource\Pages;

use App\Filament\Resources\LegalPageResource;
use Filament\Resources\Pages\EditRecord;

class EditLegalPage extends EditRecord
{
    protected static string $resource = LegalPageResource::class;

    // No DeleteAction — these 2 pages must always exist.
    protected function getHeaderActions(): array
    {
        return [];
    }
}
