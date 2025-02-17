<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeeStructureResource\Pages;
use App\Filament\Resources\FeeStructureResource\RelationManagers;
use App\Models\ClassGroups;
use App\Models\FeeStructure;
use App\Models\FeeStructures;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeeStructureResource extends Resource
{
    protected static ?string $model = FeeStructures::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Fee Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),
                Forms\Components\DatePicker::make('effective_date')
                    ->label('Effective Date')
                    ->required(),
                Forms\Components\Select::make('class_group_id')
                    ->label('Class Group')
                    ->options(ClassGroups::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Fee Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('USD'),
                Tables\Columns\TextColumn::make('classGroup.name')
                    ->label('Class Group')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('effective_date')
                    ->label('Effective Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
//                Filter::make('effective_today')
//                    ->label('Effective Today')
//                    ->query(fn ($query) => $query->whereDate('effective_date', now())),
//                Filter::make('upcoming_effective_dates')
//                    ->label('Upcoming Dates')
//                    ->query(fn ($query) => $query->where('effective_date', '>', now())),
//                Filter::make('class_group')
//                    ->label('Class Group')
//                    ->query(fn ($query, $data) => $query->where('class_group_id', $data['value']))
//                    ->form([
//                        Forms\Components\Select::make('value')
//                            ->label('Class Group')
//                            ->options(ClassGroups::all()->pluck('name', 'id')),
//                    ]),
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
            'index' => Pages\ListFeeStructures::route('/'),
            'create' => Pages\CreateFeeStructure::route('/create'),
            'edit' => Pages\EditFeeStructure::route('/{record}/edit'),
        ];
    }
}
