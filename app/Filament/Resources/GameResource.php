<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('initially_published_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('version_published_at')
                    ->required(),
                Forms\Components\TextInput::make('game_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->maxLength(50),
                Forms\Components\Toggle::make('visible')
                    ->required(),
                Forms\Components\Toggle::make('nsfw')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('thumb_url')
                    ->maxLength(255),
                Forms\Components\TextInput::make('version')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tags')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rating')
                    ->numeric(),
                Forms\Components\TextInput::make('rating_count')
                    ->numeric(),
                Forms\Components\TextInput::make('devlog')
                    ->maxLength(255),
                Forms\Components\TextInput::make('languages')
                    ->maxLength(255),
                Forms\Components\Toggle::make('platform_windows')
                    ->required(),
                Forms\Components\Toggle::make('platform_linux')
                    ->required(),
                Forms\Components\Toggle::make('platform_mac')
                    ->required(),
                Forms\Components\Toggle::make('platform_android')
                    ->required(),
                Forms\Components\Toggle::make('platform_web')
                    ->required(),
                Forms\Components\TextInput::make('stats_blocks')
                    ->numeric(),
                Forms\Components\TextInput::make('stats_menus')
                    ->numeric(),
                Forms\Components\TextInput::make('stats_options')
                    ->numeric(),
                Forms\Components\TextInput::make('stats_words')
                    ->numeric(),
                Forms\Components\TextInput::make('game_engine')
                    ->required()
                    ->maxLength(50),
                Forms\Components\Textarea::make('error')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('initially_published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version_published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('visible')
                    ->boolean(),
                Tables\Columns\IconColumn::make('nsfw')
                    ->boolean(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('thumb_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('version')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tags')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('devlog')
                    ->searchable(),
                Tables\Columns\TextColumn::make('languages')
                    ->searchable(),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('stats_menus')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stats_options')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stats_words')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game_engine')
                    ->searchable(),
            ])
            ->filters([
                TernaryFilter::make('nsfw')
                    ->label('NSFW'),
                Filter::make('windows')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('platform_windows', true)),
                Filter::make('linux')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('platform_linux', true)),
                Filter::make('mac')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('platform_mac', true)),
                Filter::make('android')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('platform_android', true)),
                Filter::make('web')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('platform_web', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
