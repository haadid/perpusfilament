<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionType: string implements HasLabel
{
    case REQUEST = 'pesan';
    case BORROW = 'pinjam';
    case RETURN = 'kembali';
    case CANCEL = 'batal';

    public function getLabel(): ?string
    {
        return str($this->value)->title();
    }
}
