<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('services'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages each service card. The section heading/intro is edited in Homepage → Section Manager → "Most Popular Photo Editing Services" — or just click "Edit Heading & Intro Text" above.';
    }
}
