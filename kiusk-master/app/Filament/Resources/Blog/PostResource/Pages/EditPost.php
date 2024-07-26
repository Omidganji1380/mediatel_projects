<?php

namespace App\Filament\Resources\Blog\PostResource\Pages;

use App\Filament\Resources\Blog\PostResource;
use App\Models\Ad\Ad;
use App\Rules\Seo;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function beforeValidate(): void
    {
        //  $this->seoEditPageBeforeValidate();
        $this->data['slug'] = Str::slug(($this->data['slug']  != "") ? $this->data['slug'] : $this->data['title_en']);
        $record = $this->record;
        /**
         * @var Ad $record
         * */
        $record->update(['created_at' => $this->data['created_at']]);
    }

    // public function updatedData($value, $key)
    // {
    //     $this->seoEditPageBeforeValidate();
    // }

    protected function afterSave(): void
    {
        $this->record->logs()->create([
            'created_by' => $this->log?->created_by ?? $this->record->user_id,
            'updated_by' => Auth::id(),
        ]);
    }

    public function seoEditPageBeforeValidate(): void
    {
        $this->validate([
            'data.seo_description' => new Seo($this->data['title'], 'des'),
            'data.seo_title' => new Seo($this->data['title'])
        ]);
    }

    protected function getActions(): array
    {
        return array_merge(parent::getActions(), [
            ButtonAction::make(__('admin.show'))
                ->openUrlInNewTab()
                ->url($this->record->link),
        ]);
    }
}
