<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\GameVersionResource\Pages;
use App\Models\GameVersion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GameVersionResource extends Resource
{
    protected static ?string $model = GameVersion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('published_at')
                    ->required(),
                Forms\Components\Select::make('game_id')
                    ->searchable()
                    ->relationship('game', 'name')
                    ->optionsLimit(10)
                    ->required(),
                Forms\Components\TextInput::make('version')
                    ->required()
                    ->maxLength(20),
                Forms\Components\Textarea::make('devlog')
                    ->required()
                    ->columnSpanFull(),
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
                Forms\Components\TextInput::make('rating')
                    ->numeric(),
                Forms\Components\TextInput::make('rating_count')
                    ->numeric(),
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
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version')
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
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating_count')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListGameVersions::route('/'),
            'create' => Pages\CreateGameVersion::route('/create'),
            'edit' => Pages\EditGameVersion::route('/{record}/edit'),
        ];
    }
}
