<?php

namespace App\Filament\Resources\Ad\CategoryResource\Pages;

use App\Filament\Resources\Ad\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function beforeValidate(): void
    {
        $this->data['slug'] = Str::slug(($this->data['slug']  != "") ? $this->data['slug'] : $this->data['name_en']);
    }

    protected function afterCreate(): void
    {
        $this->record->logs()->create([
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
    }
}
