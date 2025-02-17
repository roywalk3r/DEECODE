<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassGroupResource\Pages;
use App\Filament\Resources\ClassGroupResource\RelationManagers;
use App\Models\ClassGroup;
use App\Models\ClassGroups;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassGroupResource extends Resource
{
    protected static ?string $model = ClassGroups::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'first_name')
            ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('teacher.first_name')->label('Teacher'),
//                Tables\Columns\TextColumn::make('students_count')->counts('students'),
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
            'index' => Pages\ListClassGroups::route('/'),
            'create' => Pages\CreateClassGroup::route('/create'),
            'edit' => Pages\EditClassGroup::route('/{record}/edit'),
        ];
    }
}
