<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListGames extends ListRecords
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'in_development' => Tab::make()->query(fn ($query) => $query->where('status', 'In development')),
            'released' => Tab::make()->query(fn ($query) => $query->where('status', 'Released')),
            'prototype' => Tab::make()->query(fn ($query) => $query->where('status', 'Prototype')),
            'abandoned' => Tab::make()->query(fn ($query) => $query->where('status', 'Abandoned')),
            'canceled' => Tab::make()->query(fn ($query) => $query->where('status', 'Canceled')),
            'on_hold' => Tab::make()->query(fn ($query) => $query->where('status', 'On hold')),
        ];
    }
}
