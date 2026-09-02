<?php

namespace App\Filament\Resources\StatResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\StatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStats extends ListRecords
{
    protected static string $resource = StatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('stats'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages each stat tile. The section heading/intro is edited in Homepage → Section Manager → "Some Magnificent Numbers" — or just click "Edit Heading & Intro Text" above.';
    }
}
