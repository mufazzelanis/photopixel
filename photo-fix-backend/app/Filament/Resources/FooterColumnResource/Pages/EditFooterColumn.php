<?php

namespace App\Filament\Resources\FooterColumnResource\Pages;

use App\Filament\Resources\FooterColumnResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFooterColumn extends EditRecord
{
    protected static string $resource = FooterColumnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
