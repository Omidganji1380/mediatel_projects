<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\LineChartWidget;

class UserChart extends LineChartWidget
{

    protected static ?string $pollingInterval = '60s';
    protected static ?string $heading = 'تعداد عضویت کاربران';
    protected static ?int $sort = 3;
    public ?string $filter = 'Week';

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $time = "sub${activeFilter}s";
        $format = [
            'Minute' => '"s:\'i',
            'Hour' => '\'G:i',
            'Day' => 'l  G:00 ',
            'Week' => 'F j',
            'Month' => 'F j',
            'Year' => 'Y F',
        ];
        $formatTime = $format[$activeFilter];
        $data = collect();
        $labels = collect();
        User::where('created_at', '>=', now()->$time())
            ->orderBy('created_at')
            ->get(['created_at'])
            ->groupBy(function ($item) use ($formatTime) {
                return jdate($item->created_at)->format($formatTime);
            })
            ->each(function ($item, $key) use ($data, $labels) {
                $data->push(count($item));
                $labels->push($key);
            });
        return [
            'datasets' => [
                [
                    'label' => 'کاربر',
                    'data' => $data->toArray(),
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'Minute' => __('admin.minute'),
            'Hour' => __('admin.hour'),
            'Day' => __('admin.day'),
            'Week' => __('admin.week'),
            'Month' => __('admin.month'),
            'Year' => __('admin.year'),
        ];
    }
}
