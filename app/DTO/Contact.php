<?php

declare(strict_types=1);

namespace App\DTO;

use App\CreditCard;
use App\DTO\Casters\CreditCardCaster;
use App\DTO\Casters\DateTimeImmutableCaster;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Attributes\CastWith;

#[Strict]
class Contact extends DataTransferObject
{
    public string $name;

    public string $email;

    public int $account;

    public bool $checked;

    public string $address;

    public ?string $interest;

    public ?string $description;

    public int $transactionId;

    #[CastWith(CreditCardCaster::class)]
    public CreditCard $creditCard;

    #[CastWith(DateTimeImmutableCaster::class)]
    public ?\DateTimeImmutable $dateOfBirth;

    public function toArray(): array
    {
        $contact = array_merge(parent::toArray(), [
            'credit_card' => (string) $this->creditCard,
            'date_of_birth' => $this->dateOfBirth?->format('Y-m-d'),
            'import_transaction_id' => $this->transactionId,
        ]);

        unset($contact['creditCard'], $contact['dateOfBirth'], $contact['transactionId']);

        return $contact;
    }

    public static function new(array $item): static
    {
        return new static(
            name: $item['name'],
            email: $item['email'],
            account: $item['account'],
            checked: (bool)$item['checked'],
            address: $item['address'],
            interest: $item['interest'],
            description: $item['description'],
            creditCard: $item['credit_card'],
            dateOfBirth: $item['date_of_birth'],
            transactionId: $item['import_transaction_id']
        );
    }
}
