<?php

namespace App\Filament\Clusters\Products\Resources;
use App\Filament\Clusters\Products;
use App\Filament\Clusters\Products\Resources\WeeklyBestSellerResource\Pages;
use App\Filament\Clusters\Products\Resources\WeeklyBestSellerResource\RelationManagers;
use App\Models\WeeklyBestSeller;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Akaunting\Money\Currency;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
class WeeklyBestSellerResource extends Resource  implements HasMedia
{
    use InteractsWithMedia;
    protected static ?string $model = WeeklyBestSeller::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $cluster = Products::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Name')
                ->schema([
                TextInput::make('name')->required()->columnSpan('full')->label('product name')
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

            Forms\Components\TextInput::make('slug')
                ->disabled()
                 ->required()
                ->maxLength(255)->columnSpan('full')
                ->unique(WeeklyBestSeller::class, 'slug', ignoreRecord: true),
                ]),
                ]),
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\Select::make('currency')
                        ->options(collect(Currency::getCurrencies())->mapWithKeys(fn ($item, $key) => [$key => data_get($item, 'name')]))
                        ->searchable()
                        ->required(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                             ->required(),
                        
                        
                        Forms\Components\TextInput::make('old_price')
                            ->label('old  price')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                       ])
                    ->columns(1),

                    ])->columnSpan(['lg' => 1]),
                    Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Image')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('image')
                            ->collection('bestSeller')
                            ->label('Product Image')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->visibility('public')
                            ->required()
                            ->columnSpan('full'),
                            
                            Forms\Components\Select::make('tag')
                            ->label('Image tag')
                            ->multiple()
                            ->relationship('tags', 'name')
                            ->native(false),
                    ]),
                    ])->columnSpan('full')
                         ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                ->label('Image')
                ->collection('bestSeller'),
                TextColumn::make('price')->sortable()->searchable()
                ->money(fn ($record) => $record->currency),
                TextColumn::make('old_price')->sortable()->searchable(),
                 TextColumn::make('tags.name')->label('Tags')->sortable()->searchable(),
                TextColumn::make('status')->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->searchable(),
                TextColumn::make('updated_at')->dateTime()->sortable()->searchable(),            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListWeeklyBestSellers::route('/'),
            'create' => Pages\CreateWeeklyBestSeller::route('/create'),
            'edit' => Pages\EditWeeklyBestSeller::route('/{record}/edit'),
        ];
    }
}