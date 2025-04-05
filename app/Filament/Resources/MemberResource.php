<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Участники';

    protected static ?string $modeLabel = 'Участники';

    protected static ?string $pluralModelLabel = 'Участники';

    protected static ?string $breadcrumb = 'Участники';

    protected static ?string $label = 'Участника';

    static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->label('Номер участника')
                    ->required()
                    ->numeric()
                    ->unique(ignoreRecord: true),
                Forms\Components\ColorPicker::make('color')
                    ->label('Цвет')
                    ->required(),
                Forms\Components\TextInput::make('reaction_time')
                    ->label('Среднее время реакции на старте (мс.)')
                    ->numeric(),
                Forms\Components\TextInput::make('boost')
                    ->label('Ускорение (м/с², начальная фаза забега)')
                    ->numeric(),
                Forms\Components\TextInput::make('max_speed')
                    ->label('Максимальная скорость (м/с)')
                    ->numeric(),
                Forms\Components\TextInput::make('speed_loss')
                    ->label('Коэффициент потери скорости (на финальной стадии)')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label('Номер участника'),
                ColorColumn::make('color')
                    ->label('Цвет'),
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
