<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Concerns\HasExtraAlpineAttributes;
use Filament\Forms\Components\Concerns\HasFileAttachments;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Concerns\InteractsWithToolbarButtons;
use Filament\Forms\Components\Field;

class RangeSlider extends Field
{
    protected string $view = 'forms.components.range-slider';
 use HasExtraAlpineAttributes;
 use HasFileAttachments;
 use HasPlaceholder;
 use InteractsWithToolbarButtons;
 protected array | Closure $toolbarButtons = [
  'attachFiles',
  'blockquote',
  'bold',
  'bulletList',
  'codeBlock',
  'h2',
  'h3',
  'italic',
  'link',
  'orderedList',
  'redo',
  'strike',
  'undo',
 ];
}
