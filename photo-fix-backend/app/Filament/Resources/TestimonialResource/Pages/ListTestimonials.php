<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestimonials extends ListRecords
{
    protected static string $resource = TestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('testimonials'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages individual reviews. The section heading/intro is edited in Homepage → Section Manager → "Testimonials" — or just click "Edit Heading & Intro Text" above.';
    }
}
