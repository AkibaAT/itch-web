<?php

declare(strict_types=1);

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\RatingResource\Pages;
use App\Models\Rating;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('published_at')
                    ->width('1%')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game.name')
                    ->tooltip('Filter by this game')
                    ->disabledClick()
                    ->extraAttributes(function (Rating $record) {
                        return [
                            'wire:click' => '$set("tableFilters.game.value", "' . $record->game_id . '", true)',
                            'class' => 'transition hover:text-primary-500 cursor-pointer',
                        ];
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->width('1%')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('review')
                    ->html()
                    ->wrap(),
                Tables\Columns\TextColumn::make('rater_id')
                    ->label('Rater ID')
                    ->numeric()
                    ->tooltip('Filter by this rater')
                    ->disabledClick()
                    ->extraAttributes(function (Rating $record) {
                        return [
                            'wire:click' => '$set("tableFilters.rater_id.value", "' . $record->rater_id . '", true)',
                            'class' => 'transition hover:text-primary-500 cursor-pointer',
                        ];
                    }),
                Tables\Columns\TextColumn::make('event_id')
                    ->label('Rating ID')
                    ->numeric()
                    ->url(fn (Rating $record) => 'https://itch.io/event/' . $record->event_id)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->relationship('game', 'name', fn (Builder $query) => $query->where('visible', true)),
                Filter::make('rater_id')
                    ->form([TextInput::make('value')])
                    ->query(
                        fn (Builder $query, array $data) => $query->when($data['value'])->where('rater_id', $data['value'])
                    )
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['value']) {
                            return null;
                        }

                        return 'User ID: ' . $data['value'];
                    }),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('visible', true)
                    ->whereHas('game', function (Builder $query) {
                        $query->where('visible', true);
                    });
            })
            ->defaultSort('published_at', 'desc')
            ->paginated([10, 25, 50]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRatings::route('/'),
        ];
    }
}
