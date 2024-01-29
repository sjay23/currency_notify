<?php
declare(strict_types=1);

namespace App\Tests\Event\Subscriber;

use App\DTO\MessageInput;
use App\Entity\Bank;
use App\Entity\Currency;
use App\Service\Notify\MailerNotify;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use App\Entity\CurrencyExchange;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Event\Subscriber\CurrencyExchangeUpdateSubscriber;

class CurrencyExchangeUpdateSubscriberTest extends TestCase
{
    public function testPreUpdate(): void
    {
        $notifyMock = $this->createMock(MailerNotify::class);
        $currencyMock = $this->createMock(Currency::class);
        $bankMock = $this->createMock(Bank::class);

        $currencyExchange = new CurrencyExchange($currencyMock, $bankMock, 40.1, 42.1);

        $currencyExchange->setSellRate(45);
        $currencyExchange->setBuyRate(45);

        $changeSet = [
            'sellRate' => [40.1, 45],
            'buyRate' => [42.1, 45],
        ];

        $entityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $eventArgsMock = new PreUpdateEventArgs($currencyExchange, $entityManagerMock, $changeSet);

        $subscriber = new CurrencyExchangeUpdateSubscriber($notifyMock);
        $notifyMock->expects($this->once())->method('send')->with($this->callback(function($arg) {
            return $arg instanceof MessageInput
                && $arg->getTitle() === "Change currency exchange on bank"
                && $arg->getContent() === "The value of sell has changed to 12.22% on bank\nThe value of buy has changed to 6.89% on bank";
        }));;

        $subscriber->preUpdate($eventArgsMock);
    }
}
