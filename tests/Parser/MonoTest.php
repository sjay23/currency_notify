<?php
declare(strict_types=1);

namespace App\Tests\Parser;

use App\DTO\CurrencyExchangeInput;
use PHPUnit\Framework\TestCase;
use App\Service\Parser\Mono;


final class MonoTest extends TestCase
{
    public function testContentToArray(): void
    {
        $mockedContent = '[{"currencyCodeA":840,"currencyCodeB":980,"date":1706185206,"rateBuy":37.48,"rateSell":38.0199},{"currencyCodeA":978,"currencyCodeB":980,"date":1706185206,"rateBuy":40.8,"rateSell":41.5007}]';

        $monoParser = $this->getMockBuilder(Mono::class)
            ->onlyMethods(['getContent'])
            ->getMock();

        $monoParser->method('getContent')->willReturn($mockedContent);

        $expectedResult = [
            new CurrencyExchangeInput('USD', 37.48, 38.0199),
            new CurrencyExchangeInput('EUR', 40.8, 41.5007),
        ];

        $result = $monoParser->getData();

        $this->assertEquals($expectedResult, $result);
    }

    public function testGetErrorContent(): void
    {
        $mockedContent = 'https://api.monobank.ua/bank/currency1';

        $monoParser = $this->getMockBuilder(Mono::class)
            ->onlyMethods(['getLink'])
            ->getMock();

        $monoParser->method('getLink')->willReturn($mockedContent);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to open stream monobank');
        $monoParser->getData();
    }
}
