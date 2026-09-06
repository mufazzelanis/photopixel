<?php

namespace App\Filament\Resources\LegalPageResource\Pages;

use App\Filament\Resources\LegalPageResource;
use Filament\Resources\Pages\ListRecords;

class ListLegalPages extends ListRecords
{
    protected static string $resource = LegalPageResource::class;

    // No CreateAction — exactly 2 fixed pages, seeded once.
    protected function getHeaderActions(): array
    {
        return [];
    }
}
