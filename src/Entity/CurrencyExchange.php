<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\CurrencyExchangeRepository;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'currency_exchanges')]
#[ORM\Entity(repositoryClass: CurrencyExchangeRepository::class)]
class CurrencyExchange
{
    final public const THRESHOLD_PERCENT = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: "datetime")]
    private DateTimeInterface $updatedAt;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: "Currency")]
        private Currency $currency,

        #[ORM\ManyToOne(targetEntity: "Bank")]
        private Bank $bank,

        #[ORM\Column(type: "decimal", precision: 8, scale: 4)]
        private float $sellRate,

        #[ORM\Column(type: "decimal", precision: 8, scale: 4)]
        private float $buyRate
    )
    {
        $this->updatedAt = Carbon::now();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUpdatedAt(): DateTimeInterface|Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface|Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function getBank(): Bank
    {
        return $this->bank;
    }

    public function setBank(Bank $bank): void
    {
        $this->bank = $bank;
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
