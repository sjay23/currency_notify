<?php
declare(strict_types=1);

namespace App\Service\Parser;

use App\DTO\CurrencyExchangeInput;
use JetBrains\PhpStorm\Pure;

abstract class ParserInterface
{
    public function getData(): array
    {
       $content = $this->getContent($this->getLink());
       return $this->contentToArray($content);
    }

    #[Pure]
    protected function createCurrencyExchangeInput(string $currencyCode, float $buy, float $sell): CurrencyExchangeInput
    {
        return new CurrencyExchangeInput($currencyCode, $buy, $sell);
    }

    abstract protected function contentToArray(string $content): array;

    abstract protected function getContent(string $url): string;
    abstract protected function getLink(): string;
}
