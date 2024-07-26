<?php

namespace App\Filament\Resources\Address\StateResource\Pages;

use App\Filament\Resources\Address\StateResource;
use App\Rules\Seo;
use Filament\Resources\Pages\EditRecord;

class EditState extends EditRecord
{
 protected static string $resource = StateResource::class;

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
