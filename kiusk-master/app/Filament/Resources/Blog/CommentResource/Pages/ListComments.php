<?php

namespace App\Filament\Resources\Blog\CommentResource\Pages;

use App\Filament\Resources\Blog\CommentResource;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
 protected static string $resource = CommentResource::class;
}
