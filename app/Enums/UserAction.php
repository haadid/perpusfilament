<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserAction: string implements HasLabel
{
    case LOGIN = 'login';
    case LOGOUT = 'logout';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case RESTORE = 'restore';

    public function getLabel(): ?string
    {
        return str($this->value)->title();
    }
}
