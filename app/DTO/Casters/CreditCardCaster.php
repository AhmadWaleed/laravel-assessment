<?php

declare(strict_types=1);

namespace App\DTO\Casters;

use App\CreditCard;
use Spatie\DataTransferObject\Caster;

class CreditCardCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (is_null($value)) {
            return [];
        }

        return new CreditCard(
            (int) $value['type'],
            $value['name'],
            $value['type'],
            (new DateTimeImmutableCaster())->cast($value['expirationDate']),
        );
    }
}
