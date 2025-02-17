<?php

namespace App\Filament\Clusters\Invoices\Resources;

use App\Enums\Status;
use App\Filament\Clusters\Invoices;
use App\Filament\Clusters\Invoices\Resources\InvoicesResource\Pages;
use App\Filament\Clusters\Invoices\Resources\InvoicesResource\RelationManagers;
use App\Forms\Components\AddressForm;
use App\Models\Biller;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\TaxRate;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Random\RandomException;
use Squire\Models\Currency;

class InvoicesResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Invoices::class;

    /**
     * @throws RandomException
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema(static::getDetailsFormSchema())
                            ->columns(2),
                        Forms\Components\Section::make('Invoice items')
                            ->headerActions([
                                Action::make('reset')
                                    ->modalHeading('Are you sure?')
                                    ->modalDescription('All existing items will be removed from the order.')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Forms\Set $set) => $set('items', [])),
                            ])
                            ->schema([
                                static::getItemsRepeater(),
                            ]),
                        Forms\Components\Section::make('Billing')
                        ->schema(static::getCalculations())->columns(2),
                    ])
                    ->columnSpan(['lg' => fn (?Invoice $record) => $record === null ? 3 : 2]),
                Forms\Components\Placeholder::make('total')
                    ->label('Total Price')
                    ->content(function (Get $get): string {
                        return '₵ ' . number_format($get('total'), 2);
                    }),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Invoice $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Invoice $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Invoice $record) => $record === null),

            ])
            ->columns(3);

    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Invoice Reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label("Issued On")
                    ->sortable()
                    ->dateTime('F j, Y'), // Format date
                Tables\Columns\TextColumn::make('billTo.fullname')
                    ->label("Billed To")
                    ->searchable(),
                Tables\Columns\TextColumn::make('status') // Use BadgeColumn for status display
                ->label('Status')
                    ->badge() // Define the status values
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'paid',
                        'danger' => 'refund',
                        'warning' => 'unpaid',
                        'info' => 'overdue',
                        'dark' => 'cancelled',
                    ]), // Assign colors to statuses
                Tables\Columns\TextColumn::make('payment_date')
                    ->label("Payment Date")
                    ->sortable()
                    ->dateTime('F j, Y'), // Format payment date
                Tables\Columns\TextColumn::make('billTo.phone')
                    ->label('Phone'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Amount')
                    ->money('GHS') // Adjust currency as needed
                    ->sortable(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                        'refund' => 'Refund',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
                    ]), // Filter by status
                Tables\Filters\Filter::make('date')
                    ->label('Issued This Month')
                    ->query(fn ($query) => $query->whereMonth('date', now()->month)),
                Tables\Filters\Filter::make('payment_date')
                    ->label('Paid This Month')
                    ->query(fn ($query) => $query->whereMonth('payment_date', now()->month)),
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
    public static function getDetailsFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('reference')
                    ->label('Invoice Reference')
                    ->required()
                    ->placeholder('Enter Invoice Reference')
                    ->default('INV-' . random_int(100000, 999999))
                    ->disabled()
                    ->maxLength(32)
                    ->dehydrated()
                    ->unique(Invoice::class, 'reference', ignoreRecord: true),

                Forms\Components\DatePicker::make('date')
                    ->label('Issued On')
                    ->required()
                    ->placeholder('Select Issue Date')
                    ->format('d/m/Y')
                    ->native(false)
                    ->default(now()),

                Forms\Components\ToggleButtons::make('status')
                    ->inline()
                    ->options(Status::class)
                    ->required(),


             Forms\Components\Select::make('bill_to_id')
                ->relationship('billTo', 'fullname')
                ->label('Issued To')
                ->searchable()
                ->preload()
                ->createOptionForm([
                    Forms\Components\TextInput::make('billTo.fullname')
                        ->required()
                        ->maxLength(255)
                        ->reactive() // Ensure reactivity for state changes
                            ->live(),

                    Forms\Components\TextInput::make('billTo.email')
                        ->label('Email address')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('billTo.phone')
                        ->label('Phone number')
                        ->tel()
                        ->required(),
                ]),

            Forms\Components\Select::make('currency')
                ->searchable()
                ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                ->getOptionLabelUsing(fn ($value): ?string => Currency::firstWhere('id', $value)?->getAttribute('name'))
                ->required()->default('Ghanaian Cedi')
                ->native(false)
                ->noSearchResultsMessage('No such currency found.'),
//            AddressForm::make('address')
//                ->columnSpan('full'),

            Forms\Components\MarkdownEditor::make('note')
                ->columnSpan('full'),
        ];
    }





    public static function getItemsRepeater(): Repeater
    {
        return Repeater::make('invoicesItems')
        ->relationship()
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->label('Product')
                    ->options(Item::query()->pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Fetch the latest price and stock quantity for the selected item
                        $item = Item::find($state);

                        // Set the name, unit price, and available stock for the selected item
                        $set('name', $item?->name ?? 'Unnamed Item');
                        $set('unit_price', $item?->latestPrice?->price ?? 0);
                        $set('available_stock', $item?->stock?->quantity ?? 0);

                        // Recalculate totals after the item is updated
                        self::updateTotals($get, $set);
                    })

                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->columnSpan(['md' => 5])
                    ->searchable(),

                Forms\Components\TextInput::make('name')
                    ->label('Item Name')
                    ->dehydrated()->default('Test')
                    ->hidden(),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->default(0)
                    ->minValue(1)
                    ->columnSpan(['md' => 2])
                    ->required()
                     ->reactive()
                    ->afterStateUpdated(function ($state,  $set,   $get) {
                        $itemId = $get('item_id');
                        $item = Item::find($itemId);
                        $stockQty = $item?->stock?->quantity ?? 0;

                        $set('total_price', $item?->latestPrice?->price * ($state ?? 0));

                        if ($state > $stockQty) {
                            $set('quantity', $stockQty);
                            session()->flash('error', "Quantity adjusted to available stock of {$stockQty}");
                        }

                        // Recalculate totals after the quantity is updated
                        self::updateTotals($get, $set);
                    })->live(),
                Forms\Components\TextInput::make('unit_price')
                    ->label('Unit Price')
                    ->disabled()
                    ->dehydrated()
                    ->numeric()
                    ->required()
                    ->columnSpan(['md' => 3]),

                Forms\Components\TextInput::make('available_stock')
                    ->label('Available Stock')
                    ->disabled()
                    ->numeric()
                    ->columnSpan(['md' => 2]), // Optional: Show stock level for user reference

                Forms\Components\TextInput::make('total_price')
                    ->label('Total price')
                    ->disabled()
                    ->reactive()
                    ->live(true)
                    ->numeric()
                    ->columnSpan(['md' => 2]),
            ])
            ->live()
            ->afterStateUpdated(function (Get $get, Set $set) {
                self::updateTotals($get, $set);
            })


            ->deleteAction(
                fn(Action $action) => $action->after(fn(Get $get, Set $set) => self::updateTotals($get, $set)),
            )
            ->reorderableWithDragAndDrop(false)
            ->collapsible()
            ->defaultItems(1)
            ->hiddenLabel()
            ->columns(['md' => 10])
            ->required();
    }

//    public static function getTaxes(): Repeater{
//        return Repeater::make('invoiceTax')
//            ->relationship('invoiceTax')
//            ->schema([
//                Forms\Components\Select::make('tax_rate_id')
//                    ->label('Tax Rate')
//                    ->options(function (): array {
//                        return TaxRate::all()->pluck('value', 'id')->mapWithKeys(function ($value, $id) {
//                            $label = TaxRate::find($id)->label;
//                            return [$id => "{$label} ({$value} $)"];
//                        })->toArray();
//                    })
//                    ->required(),
//                Forms\Components\TextInput::make('label')
//                    ->required(),
//                Forms\Components\TextInput::make('value')
//                    ->numeric()
//                    ->required(),
//                Forms\Components\Select::make('type')
//                    ->options([
//                        0 => 'Fixed',
//                        1 => 'Percentage',
//                    ])
//                    ->required(),
//            ])
//            ->live()
//            ->deleteAction(
//                fn(Action $action) => $action->after(fn(Get $get, Set $set) => self::updateTotals($get, $set)),
//            )
//            ->reorderableWithDragAndDrop(false)
//            ->collapsible()
//            ->defaultItems(1)
//            ->hiddenLabel()
//            ->columns(['md' => 10]);
//    }

// This function updates totals based on the selected products and quantities
    public static function getCalculations(): array
    {
        return [
            Forms\Components\TextInput::make('subtotal')
                ->numeric()
                ->readOnly()
                ->prefix('$')
                ->afterStateHydrated(function (Get $get, Set $set) {
                    self::updateTotals($get, $set);
                }),
            Forms\Components\Section::make('Tax Information')
                ->schema([
                    Forms\Components\Repeater::make('invoiceTax')
                        ->relationship('invoiceTax') // Use the correct relationship name
                        ->schema([
                            Forms\Components\Select::make('tax_rate_id') // Use the pivot column 'tax_rate_id'
                                ->label('Tax Rate')
                                ->options(function (): array {
                                    return TaxRate::all()->pluck('value', 'id')->mapWithKeys(function ($value, $id) {
                                        $label = TaxRate::find($id)->label; // Fetch the label based on the tax rate id
                                        return [$id => "{$label} ({$value} $)"];
                                    })->toArray();
                                }) ->reactive()
                                ->afterStateUpdated(fn (Forms\Set $set, $state) => self::updateTaxFields($set, $state))
                                ->required(),
                            Forms\Components\TextInput::make('label')
                                ->required(),
                            Forms\Components\TextInput::make('value')
                                ->numeric()
                                ->required(),
                            Forms\Components\Select::make('type')
                                ->options([
                                    0 => 'Fixed',
                                    1 => 'Percentage',
                                ])
                                ->required(),
                            Forms\Components\Checkbox::make('is_conditional')
                                ->label('Conditional Tax'),
                        ])
                        ->columns(2),
                ]),

            Forms\Components\TextInput::make('total_tax')
                ->suffix('$')  // Fixed tax amount, not percentage
                ->numeric()
                ->required()
                ->reactive()
                ->live(true)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    self::updateTotals($get, $set);
                }),

            Forms\Components\TextInput::make('total')
                ->numeric()
                ->readOnly()
                ->reactive()
                ->live(true)
                ->prefix('$'),
        ];
    }

    public static function updateTaxFields(Forms\Set $set, $taxRateId): void
    {
        $taxRate = TaxRate::find($taxRateId);
        if ($taxRate) {
            $set('label', $taxRate->label);
            $set('value', $taxRate->value);
            $set('type', $taxRate->type);
            $set('is_conditional', $taxRate->is_conditional);
          }
    }

    public static function updateTotals(Forms\Get $get, Forms\Set $set): void
    {
        $items = collect($get('invoicesItems'));
        $subtotal = $items->reduce(function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['unit_price']);
        }, 0);

        $taxes = collect($get('invoiceTax'));
        $totalTax = $taxes->sum('value');

        $total = $subtotal + $totalTax;

        $set('subtotal', number_format($subtotal, 2, '.', ''));
        $set('total_tax', number_format($totalTax, 2, '.', ''));
        $set('total', number_format($total, 2, '.', ''));
    }
    //    public static function updateTotals($get, $set): void
//    {
//
//        // Retrieve the selected tax rate
//        $selectedTaxRateId = $get('tax_rate_id');
//        $selectedTaxRate = TaxRate::find($selectedTaxRateId);
//        $taxValue = $selectedTaxRate ? $selectedTaxRate->value : 0;
//
//        // Retrieve all selected invoice items
//        $selectedItems = collect($get('invoicesItems'))
//            ->filter(fn($item) => !empty($item['item_id']) && !empty($item['quantity']));
//
//        // Calculate subtotal based on selected items
//        $subtotal = $selectedItems->reduce(function ($subtotal, $item) {
//            $unitPrice = $item['unit_price'] ?? 0;
//            $quantity = $item['quantity'] ?? 0;
//            $discount = $item['discount'] ?? 0;
//
//            // Apply discount to calculate item total
//            $discountedPrice = $unitPrice - ($unitPrice * ($discount / 100));
//            $itemTotal = $discountedPrice * $quantity;
//
//            return $subtotal + $itemTotal;
//        }, 0);
//
//        // Total tax is the fixed amount from the selected tax rate
//        $totalTax = $taxValue; // Fixed tax value from the selected tax rate
//
//        // Calculate total (subtotal + the fixed tax amount)
//        $total = $subtotal + $totalTax;
//
//        // Update the state with the calculated values
//        $set('subtotal', number_format($subtotal, 2, '.', ''));
//        $set('total', number_format($total, 2, '.', ''));
//        $set('total_tax', number_format($totalTax, 2, '.', '')); // Fixed tax value
//    }



    /** @return Builder<Invoice> */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('invoiceTax');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'customer.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Invoice $record */

        return [
            'Customer' => optional($record->customer)->fullname,
        ];
    }

    /** @return Builder<Invoice> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['customer', 'items']);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoices::route('/create'),
            'edit' => Pages\EditInvoices::route('/{record}/edit'),
        ];
    }

}
