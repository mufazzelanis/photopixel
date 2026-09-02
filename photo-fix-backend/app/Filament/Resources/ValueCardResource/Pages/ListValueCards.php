<?php

namespace App\Filament\Resources\ValueCardResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\ValueCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValueCards extends ListRecords
{
    protected static string $resource = ValueCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('value_cards'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages the 4 colored cards. The heading, intro paragraphs and "Learn More About Us" button next to them are edited in Homepage → Section Manager → "The Range Of Value We Provide" (leave a blank line between paragraphs) — or just click "Edit Heading & Intro Text" above.';
    }
}
