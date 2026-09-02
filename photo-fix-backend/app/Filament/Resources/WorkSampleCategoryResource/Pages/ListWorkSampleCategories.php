<?php

namespace App\Filament\Resources\WorkSampleCategoryResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\WorkSampleCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkSampleCategories extends ListRecords
{
    protected static string $resource = WorkSampleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('work_samples', 'Edit Homepage Teaser Heading'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'Each category\'s own heading, description and buttons are edited right here (open a category, below). Only the small "Work Samples" teaser strip on the homepage is edited separately — click "Edit Homepage Teaser Heading" above.';
    }
}
