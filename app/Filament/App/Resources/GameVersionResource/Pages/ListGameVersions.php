<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\GameVersionResource\Pages;

use App\Filament\App\Resources\GameVersionResource;
use Filament\Resources\Pages\ListRecords;

class ListGameVersions extends ListRecords
{
    protected static string $resource = GameVersionResource::class;

    public function updatedTableRecordsPerPage(): void
    {
        if (! in_array($this->getTableRecordsPerPage(), [10, 25, 50])) {
            $this->tableRecordsPerPage = 10;
        }

        parent::updatedTableRecordsPerPage();
    }
}
