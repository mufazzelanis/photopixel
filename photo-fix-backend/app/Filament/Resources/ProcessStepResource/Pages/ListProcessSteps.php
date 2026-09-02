<?php

namespace App\Filament\Resources\ProcessStepResource\Pages;

use App\Filament\Resources\ProcessStepResource;
use App\Filament\Resources\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcessSteps extends ListRecords
{
    protected static string $resource = ProcessStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('work_process'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages each step. The section heading/intro is edited in Homepage → Section Manager → "Easiest Work Process" — or just click "Edit Heading & Intro Text" above.';
    }
}
