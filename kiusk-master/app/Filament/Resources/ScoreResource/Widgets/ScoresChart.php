<?php

namespace App\Filament\Resources\ScoreResource\Widgets;

use Filament\Widgets\BarChartWidget;

class ScoresChart extends BarChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }
}
