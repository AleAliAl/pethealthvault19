<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Pet;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Users', Cache::remember('user_count', 60, fn () => User::count())) // Cache count for 60 seconds
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->chart([5, 10, 15, 20, 25, 30])
                ->color('success'),

            Stat::make('Total Pets', Cache::remember('pet_count', 60, fn () => Pet::count())) // Cache count for 60 seconds
                ->description('Number of pets registered in the system')
                ->descriptionIcon('heroicon-m-heart', IconPosition::Before)
                ->chart([2, 4, 8, 16, 32])
                ->color('info'),
        ];
    }
}
