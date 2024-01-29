<?php
declare(strict_types=1);

namespace App\Tests\Parser;

use App\DTO\CurrencyExchangeInput;
use App\Service\Parser\Privat24;
use PHPUnit\Framework\TestCase;

final class Privat24Test extends TestCase
{
    public function testContentToArray(): void
    {
        $mockedContent = '[{"ccy":"EUR","base_ccy":"UAH","buy":"40.60000","sale":"41.66667"},{"ccy":"USD","base_ccy":"UAH","buy":"37.29000","sale":"38.02281"}]';

        $monoParser = $this->getMockBuilder(Privat24::class)
            ->onlyMethods(['getContent'])
            ->getMock();

        $monoParser->method('getContent')->willReturn($mockedContent);

        $expectedResult = [
            new CurrencyExchangeInput('USD', 37.29000, 38.02281),
            new CurrencyExchangeInput('EUR', 40.60000, 41.66667),
        ];

        $result = $monoParser->getData();

        $this->assertEquals($expectedResult, $result);
    }
}
