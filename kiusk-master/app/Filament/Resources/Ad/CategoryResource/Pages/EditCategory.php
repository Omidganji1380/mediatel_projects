<?php

namespace App\Filament\Resources\Ad\CategoryResource\Pages;

use App\Filament\Resources\Ad\CategoryResource;
use App\Rules\Seo;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function beforeValidate(): void
    {
        $this->data['slug'] = Str::slug(($this->data['slug'] != "") ? $this->data['slug'] : $this->data['name_en']);
        $this->seoEditPageBeforeValidate();
    }

    public function updatedData($value, $key)
    {
        // $this->seoEditPageBeforeValidate();
    }

    protected function afterSave(): void
    {
        $this->record->logs()->create([
            'created_by' => $this->log?->created_by ?? Auth::id(),
            'updated_by' => Auth::id(),
        ]);
    }

    public function seoEditPageBeforeValidate(): void
    {
        $this->validate([
                         'data.seo_description' => new Seo($this->data['name'], 'des'),
                         'data.seo_title' => new Seo($this->data['name']),
                        ]);
    }
}
