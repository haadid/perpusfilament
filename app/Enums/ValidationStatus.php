<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ValidationStatus: string implements HasLabel
{
    case PENDING = 'pending';
    case APPROVED = 'disetujui';
    case REJECTED = 'ditolak';
    case CANCELLED = 'dibatalkan';
    case EXPIRED = 'kedaluwarsa';
    case COMPLETED = 'selesai';

    public function getLabel(): ?string
    {
        return str($this->value)->title();
    }
}
