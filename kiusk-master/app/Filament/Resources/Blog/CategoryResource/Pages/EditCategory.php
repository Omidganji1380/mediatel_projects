<?php

namespace App\Filament\Resources\Blog\CategoryResource\Pages;

use App\Filament\Resources\Blog\CategoryResource;
use App\Rules\Seo;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function beforeValidate(): void
    {
        $this->seoEditPageBeforeValidate();
    }

    public function updatedData($value, $key)
    {
        $this->seoEditPageBeforeValidate();
    }

    public function seoEditPageBeforeValidate(): void
    {
        $this->validate([
            'data.seo_description' => new Seo($this->data['name'], 'des'),
            'data.seo_title' => new Seo($this->data['name'])
        ]);
    }
}
