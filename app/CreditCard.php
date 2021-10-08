<?php

declare(strict_types=1);

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class CreditCard implements Arrayable, \Stringable
{
    public function __construct(
        public int $number,
        public string $name,
        public string $type,
        public \DateTimeImmutable $expirationDate,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'number' => $this->number,
            'expiration_date' => $this->expirationDate->format('m/d'),
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}
