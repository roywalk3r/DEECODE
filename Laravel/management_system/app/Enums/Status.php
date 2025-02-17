<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasIcon, HasLabel
{
    case Refund = 'refund';

    case Paid = 'paid';

    case Unpaid = 'unpaid';

    case OverDue = 'overdue';

    case Cancelled = 'cancelled';

    case Partial = 'partial';
    public function getLabel(): string  | null
    {
        return match ($this) {
            self::Refund => 'Refund',
            self::Paid => 'Paid',
            self::Unpaid => 'Unpaid',
            self::OverDue => 'Overdue',
            self::Cancelled => 'Cancelled',
            self::Partial => 'Partial',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Unpaid => 'info',
            self::OverDue, self::Partial => 'warning',
            self::Paid => 'success',
            self::Refund, self::Cancelled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Partial => 'heroicon-m-sparkles',
            self::Unpaid => 'heroicon-m-arrow-path',
            self::OverDue => 'heroicon-m-truck',
            self::Paid => 'heroicon-m-check-badge',
            self::Cancelled => 'heroicon-m-x-circle',
            self::Refund => 'heroicon-m-archive-box-x-mark',
        };
    }
}
