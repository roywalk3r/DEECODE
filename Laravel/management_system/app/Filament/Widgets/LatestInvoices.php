<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestInvoices extends BaseWidget
{
    protected static ?int $sort = 5;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Invoice::query()->latest('date')->take(10) // Fetch the latest 4 invoices
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Invoice Reference')
                     ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->dateTime('F j, Y') // Format date
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Amount')
                    ->money('GHS') // Adjust currency as needed
                    ->sortable(),
            ]);
    }
}
