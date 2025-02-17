<?php

namespace App\Filament\Clusters\Invoices\Resources\InvoicesResource\Pages;

use App\Filament\Clusters\Invoices\Resources\InvoicesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvoices extends EditRecord
{
    protected static string $resource = InvoicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
