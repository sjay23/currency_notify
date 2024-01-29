<?php
declare(strict_types=1);

namespace App\Service\Parser;

use Symfony\Component\Config\Definition\Exception\Exception;

class Privat24 extends ParserInterface
{
    protected function contentToArray(string $content): array
    {
        $jsonContent = json_decode($content, true);
        if ($jsonContent && isset($jsonContent[1])) {
            return [
                $this->createCurrencyExchangeInput('USD', (float)$jsonContent[1]['buy'], (float)$jsonContent[1]['sale']),
                $this->createCurrencyExchangeInput('EUR', (float)$jsonContent[0]['buy'], (float)$jsonContent[0]['sale'])
            ];
        }
    }

    protected function getContent(string $url): string
    {
        $response = @file_get_contents($url);
        if (!$response) {
            throw new Exception('Failed to open stream Privat24');
        }

        return $response;
    }

    protected function getLink(): string
    {
        return 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11';
    }
}
