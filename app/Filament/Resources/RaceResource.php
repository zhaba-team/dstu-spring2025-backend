<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\RaceResource\Pages;
use App\Filament\Resources\RaceResource\RelationManagers;
use App\Models\MemberRace;
use App\Models\Race;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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

    protected static ?string $label = 'Забег';

    static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('№')
                    ->disabled(),
                Repeater::make('raceMembers')
                    ->label('Участники забега')
                    ->relationship()
                    ->reorderable()
                    ->schema([
                        TextInput::make('place')
                                 ->label('Место')
                                 ->disabled(),
                         Fieldset::make('member')
                             ->relationship('member')
                             ->schema([
                                  TextInput::make('number')
                                        ->label('Номер участника')
                                      ->disabled(),
                                  Forms\Components\ColorPicker::make('color')
                                        ->label('Цвет')
                                          ->disabled(),
                              ])
                                 ->label('Участник'),
                     ])
                    ->orderColumn('place')
                    ->columns(6)
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('№')
                    ->sortable()
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
            'index' => Pages\ListRaces::route('/'),
            'create' => Pages\CreateRace::route('/create'),
        ];
    }
}
