<?php

namespace App\Filament\Clusters\Invoices\Resources\InvoicesResource\Pages;

use App\Filament\Clusters\Invoices\Resources\InvoicesResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Random\RandomException;

class CreateInvoices extends CreateRecord
{
    protected static string $resource = InvoicesResource::class;

    /**
     * @throws RandomException
     */
    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                     ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                     ->contained(false),
            ])
            ->columns(null);
    }
    protected function afterCreate(): void
    {
        /** @var Order $order */
        $order = $this->record;

        /** @var User $user */
        $user = auth()->user();
        $allUsers = User::all();
        Notification::make()
            ->title('New Invoice')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$order->customer?->name} ordered {$order->items->count()} products.**")
            ->actions([
                Action::make('View')
                    ->url(InvoicesResource::getUrl('edit', ['record' => $order])),
            ])
            ->sendToDatabase($allUsers);
    }

    /** @return Step[]
     * @throws RandomException
     */
    protected function getSteps(): array
    {
        return [
            Step::make('Invoice Details')
                ->icon('heroicon-m-clipboard-document-list')
                ->schema([
                    Section::make()->schema(InvoicesResource::getDetailsFormSchema())->columns(),
                ]),

            Step::make('Invoice Items')
                ->icon('heroicon-m-shopping-bag')
                ->schema([
                    Section::make()->schema([
                        InvoicesResource::getItemsRepeater(),
                    ]),
                ]),
            Step::make('Billings')
            ->icon('heroicon-o-credit-card')
            ->schema([
                Section::make()->schema([
                    Section::make()->schema(InvoicesResource::getCalculations())->columns(),
                ]),
            ]),
        ];
    }
}
