<?php

namespace App\Filament\App\Resources\RatingResource\Pages;

use App\Filament\App\Resources\RatingResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRatings extends ListRecords
{
    protected static string $resource = RatingResource::class;

    public function updatedTableRecordsPerPage(): void
    {
        if (!in_array($this->getTableRecordsPerPage(), [10, 25, 50])) {
            $this->tableRecordsPerPage = 10;
        }

        parent::updatedTableRecordsPerPage();
    }

    public function getTabs(): array
    {
        return [
            'with_review' => Tab::make()->query(fn (Builder $query) => $query->where('has_review', true)),
            'all' => Tab::make('All Ratings'),
        ];
    }
}
