<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count()),
            Stat::make('Total Admins', User::role(User::ROLE_ADMIN)->count()),
            Stat::make('Total Editors', User::role(User::ROLE_EDITOR)->count()),
        ];
    }
}
