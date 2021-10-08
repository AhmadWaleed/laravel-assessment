<?php

declare(strict_types=1);

namespace App\DTO\Casters;

use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;
use Carbon\Exceptions\InvalidFormatException;

class DateTimeImmutableCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (is_null($value)) {
            return null;
        }

        try {
            $date = Carbon::parse($value)->toDateTimeImmutable();
        } catch (InvalidFormatException) {
            return null;
        }

        return $date;
    }
}
