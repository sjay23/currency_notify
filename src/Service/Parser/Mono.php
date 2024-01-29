<?php
declare(strict_types=1);

namespace App\Service\Parser;

use Symfony\Component\Config\Definition\Exception\Exception;

class Mono extends ParserInterface
{
    protected function contentToArray(string $content): array
    {
        $jsonContent = json_decode($content, true);
        if ($jsonContent && isset($jsonContent[1])) {
            return [
                $this->createCurrencyExchangeInput('USD', (float)$jsonContent[0]['rateBuy'], (float)$jsonContent[0]['rateSell']),
                $this->createCurrencyExchangeInput('EUR', (float)$jsonContent[1]['rateBuy'], (float)$jsonContent[1]['rateSell'])
            ];
        }
    }

    protected function getContent(string $url): string
    {
        $response = @file_get_contents($url);
        if (!$response) {
            throw new Exception('Failed to open stream monobank');
        }

        return $response;
    }

    protected function getLink(): string
    {
        return 'https://api.monobank.ua/bank/currency';
    }
}
