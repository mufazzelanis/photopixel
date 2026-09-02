<?php

namespace App\Filament\Resources\BlogPostResource\Pages;

use App\Filament\Resources\BlogPostResource;
use App\Filament\Resources\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlogPosts extends ListRecords
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SectionResource::editHeadingAction('blog', 'Edit Homepage Teaser Heading'),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'This only manages individual posts. The blog teaser strip\'s heading on the homepage is edited in Homepage → Section Manager → "Blogs & Articles" — or just click "Edit Homepage Teaser Heading" above.';
    }
}
