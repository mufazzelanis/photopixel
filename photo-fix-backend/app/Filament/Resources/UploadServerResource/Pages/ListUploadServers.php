<?php

namespace App\Filament\Resources\UploadServerResource\Pages;

use App\Filament\Resources\UploadServerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUploadServers extends ListRecords
{
    protected static string $resource = UploadServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
