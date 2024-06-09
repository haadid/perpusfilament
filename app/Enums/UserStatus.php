<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserStatus: string implements HasLabel
{
    case ACTIVE = 'active';
    case IN_ACTIVE = 'inactive';
    case BLACKLISTED = 'blacklisted';

    public function getLabel(): ?string
    {
        return str(str($this->value)->replace('_', ' '))->title();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::IN_ACTIVE => 'warning',
            self::BLACKLISTED => 'danger',
        };
    }
}
