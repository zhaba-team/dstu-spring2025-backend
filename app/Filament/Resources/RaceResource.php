<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\RaceResource\Pages;
use App\Filament\Resources\RaceResource\RelationManagers;
use App\Models\Race;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RaceResource extends Resource
{
    protected static ?string $model = Race::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Забеги';

    protected static ?string $modeLabel = 'Забеги';

    protected static ?string $pluralModelLabel = 'Забеги';

    protected static ?string $breadcrumb = 'Забеги';

    protected static ?string $label = 'забега';

    static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
                 TextEntry::make('id')
                     ->label('№'),
                 RepeatableEntry::make('raceMembers')
                     ->label('Участники забега')
                     ->schema([
                         TextEntry::make('member.number')
                             ->label('Номер участника'),
                         ColorEntry::make('member.color')
                             ->label('Цвет'),
                         TextEntry::make('place')
                             ->label('Место'),
                     ])->columns(3),
             ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('№')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListRaces::route('/'),
        ];
    }
}
