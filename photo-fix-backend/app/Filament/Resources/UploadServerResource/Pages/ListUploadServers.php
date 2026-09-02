<?php

namespace App\Filament\Resources\UploadServerResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\UploadServerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUploadServers extends ListRecords
{
    protected static string $resource = UploadServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('upload_servers'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages each upload-service button. The section heading/intro is edited in Homepage → Section Manager → "Upload Files To Our Servers" — or just click "Edit Heading & Intro Text" above.';
    }
}
