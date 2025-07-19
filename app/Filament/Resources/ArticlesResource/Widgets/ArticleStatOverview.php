<?php

namespace App\Filament\Resources\ArticlesResource\Widgets;

use App\Models\Articles;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArticleStatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('This Month Articles', $this->getValue())
                ->description($this->getDifference() . " Number of articles")
                ->chart($this->getChartValue())
                ->descriptionIcon($this->getChartDescriptionIcon(), IconPosition::Before)
                ->color($this->getChartColor()),
        ];
    }
    protected function getValue(): int
    {
        return Articles::month(now())->count();
    }
    protected function getChartValue(): array
    {

        return Articles::whereYear('created_at', now()->year)
            ->get()
            ->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('m');
            })
            ->map(function ($articles) {
                return $articles->count();
            })
            ->toArray();
    }
    protected function getChartColor(): string
    {
        return $this->isCurrentMoreThanLast() ? 'success' : 'danger';
    }

    protected function getChartDescriptionIcon(): string
    {
        return $this->isCurrentMoreThanLast() ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
    }
    protected function isCurrentMoreThanLast(): bool
    {
        return $this->currentMonthCount() > $this->lastMonthCount();
    }

    protected function currentMonthCount(): int
    {
        return Articles::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }
    protected function lastMonthCount(): int
    {
        return Articles::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->subMonth())
            ->count();
    }

    protected function getDifference(): int
    {
        return $this->currentMonthCount() - $this->lastMonthCount();
    }
}
