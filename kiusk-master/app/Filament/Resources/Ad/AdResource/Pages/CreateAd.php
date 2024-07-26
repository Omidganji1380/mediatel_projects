<?php

namespace App\Filament\Resources\Ad\AdResource\Pages;

use App\Filament\Resources\Ad\AdResource;
use App\Jobs\SitemapGenerateJob;
use App\Models\Ad\Ad;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateAd extends CreateRecord
{
    protected static string $resource = AdResource::class;

    protected function beforeValidate(): void
    {
        $this->data['slug'] = Str::slug(($this->data['slug']  != "") ? $this->data['slug'] : $this->data['title_en']);
    }

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
