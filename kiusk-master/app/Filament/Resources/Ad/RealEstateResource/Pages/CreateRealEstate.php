<?php

namespace App\Filament\Resources\Ad\RealEstateResource\Pages;

use App\Filament\Resources\Ad\RealEstateResource;
use App\Jobs\SitemapGenerateJob;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRealEstate extends CreateRecord
{
    protected static string $resource = RealEstateResource::class;

    protected function afterCreate(): void
    {
        $this->record->logs()->create([
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
        // Generate sitemap if visible
        if($this->record->is_visible)
            SitemapGenerateJob::dispatch();
    }
}
