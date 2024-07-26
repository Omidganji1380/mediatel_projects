<?php

namespace App\Filament\Resources\GoogleReviewResource\Pages;

use App\Filament\Resources\GoogleReviewResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGoogleReviews extends ListRecords
{
    protected static string $resource = GoogleReviewResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
