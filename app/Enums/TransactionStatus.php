<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionStatus: string implements HasLabel
{
    case PENDING = 'diproses';
    case CANCELLED = 'dibatalkan';
    case APPROVED = 'disetujui';
    case DENIED = 'ditolak';
    case BORROWED = 'dipinjam';
    case RETURNED = 'dikembalikan';
    case OVERDUE = 'terlambat';
    case COMPLETED = 'selesai';

    public function getLabel(): ?string
    {
        return str($this->value)->title();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::CANCELLED => 'red',
            self::APPROVED => 'green',
            self::DENIED => 'red',
            self::BORROWED => 'blue',
            self::RETURNED => 'green',
            self::OVERDUE => 'red',
            self::COMPLETED => 'green'
        };
    }
}
