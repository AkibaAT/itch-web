<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\GameVersionResource\Pages;
use App\Filament\App\Resources\GameVersionResource\RelationManagers;
use App\Models\GameVersion;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GameVersionResource extends Resource
{
    protected static ?string $model = GameVersion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game.name')
                    ->searchable()
                    ->sortable()
                    ->tooltip('Filter by this game')
                    ->disabledClick()
                    ->extraAttributes(function (GameVersion $record) {
                        return [
                            'wire:click' => '$set("tableFilters.game.value", "' . $record->game_id . '", true)',
                            'class' => 'transition hover:text-primary-500 cursor-pointer',
                        ];
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('version'),
                Tables\Columns\IconColumn::make('platform_windows')
                    ->boolean(),
                Tables\Columns\IconColumn::make('platform_linux')
                    ->boolean(),
                Tables\Columns\IconColumn::make('platform_mac')
                    ->boolean(),
                Tables\Columns\IconColumn::make('platform_android')
                    ->boolean(),
                Tables\Columns\IconColumn::make('platform_web')
                    ->boolean(),
                Tables\Columns\TextColumn::make('stats_blocks')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('stats_menus')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('stats_options')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('stats_words')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating_count')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->relationship('game', 'name', fn (Builder $query) => $query->where('visible', true)),
            ])
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
            'index' => Pages\ListGameVersions::route('/'),
        ];
    }
}
