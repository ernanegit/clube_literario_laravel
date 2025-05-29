<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class StatsOverview extends Widget
{
    protected static string $view = 'filament.widgets.stats-overview';
    
    public static function canView(): bool
    {
        return false; // Nunca mostrar este widget
    }
}