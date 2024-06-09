<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ValidationType: string implements HasLabel
{
    case EDIT = 'edit';
    case DELETE = 'delete';

    public function getLabel(): ?string
    {
        return str($this->value)->title();
    }
}
