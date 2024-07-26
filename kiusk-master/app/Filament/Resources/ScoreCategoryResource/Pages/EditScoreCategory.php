<?php

namespace App\Filament\Resources\ScoreCategoryResource\Pages;

use App\Filament\Resources\ScoreCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScoreCategory extends EditRecord
{
    protected static string $resource = ScoreCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
