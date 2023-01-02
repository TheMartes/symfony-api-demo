<?php

namespace App\Components\Domain\ValueObjects;

class StoreValueObject
{
    public function __construct(
        private readonly string $storeName,
        private readonly string $storeCode,
        private readonly int $active,
        private readonly array $storeChars,
        private readonly string $openingDate,
        private readonly ?string $closingDate
    ) {}

    public function getStoreName(): string
    {
        return $this->storeName;
    }

    public function getStoreCode(): string
    {
        return $this->storeCode;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function getOpeningDate(): string
    {
        return $this->openingDate;
    }

    public function getClosingDate(): ?string
    {
        return $this->closingDate;
    }

    public function getStoreChars(): array
    {
        return $this->storeChars;
    }

}
