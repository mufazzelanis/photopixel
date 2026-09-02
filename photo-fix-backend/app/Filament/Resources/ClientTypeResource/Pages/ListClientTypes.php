<?php

namespace App\Filament\Resources\ClientTypeResource\Pages;

use App\Filament\Resources\ClientTypeResource;
use App\Filament\Resources\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientTypes extends ListRecords
{
    protected static string $resource = ClientTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('client_types'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages the client-type cards. The section heading/intro is edited in Homepage → Section Manager → "Top-Tier Clients" — or just click "Edit Heading & Intro Text" above.';
    }
}
