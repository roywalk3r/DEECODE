<?php

namespace App\Filament\Clusters\Invoices\Resources\InvoicesResource\Pages;

use App\Filament\Clusters\Invoices\Resources\InvoicesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
