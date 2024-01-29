<?php
declare(strict_types=1);

namespace App\DTO;

class CurrencyExchangeInput
{
    public function __construct(
        private string $currencyCode,
        private float $buyRate,
        private float $sellRate,
    )
    {
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getSellRate(): float
    {
        return $this->sellRate;
    }

    public function setSellRate(float $sellRate): void
    {
        $this->sellRate = $sellRate;
    }

    public function getBuyRate(): float
    {
        return $this->buyRate;
    }

    public function setBuyRate(float $buyRate): void
    {
        $this->buyRate = $buyRate;
    }
}
