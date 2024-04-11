<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Company;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Empresas Cadastradas', Company::count()),
            Stat::make('Empresas Aptas para Visitas', Company::query()->where('released', "Sim")->count()),
            Stat::make('Usuários Cadastrados',User::count()),
        ];
    }
}
