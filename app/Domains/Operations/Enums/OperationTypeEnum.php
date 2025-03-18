<?php

namespace App\Domains\Operations\Enums;

enum OperationTypeEnum: int
{
    case OPERATION_TYPE_DEBIT = 1;
    case OPERATION_TYPE_CREDIT = 2;

    public function title(): string
    {
        return match ($this) {
            self::OPERATION_TYPE_DEBIT => 'Debit',
            self::OPERATION_TYPE_CREDIT => 'Credit',
            default => 'Unknown',
        };
    }
}
