<?php

namespace App\Filament\Resources\ValueCardResource\Pages;

use App\Filament\Resources\ValueCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValueCards extends ListRecords
{
    protected static string $resource = ValueCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
