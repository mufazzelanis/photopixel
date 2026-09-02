<?php

namespace App\Filament\Resources\FooterColumnResource\Pages;

use App\Filament\Resources\FooterColumnResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFooterColumns extends ListRecords
{
    protected static string $resource = FooterColumnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
