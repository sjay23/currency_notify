<?php
declare(strict_types=1);

namespace App\Event\Subscriber;

use App\DTO\MessageInput;
use App\Entity\CurrencyExchange;
use App\Service\Notify\NotifyInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Exception;
use JetBrains\PhpStorm\Pure;

#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class CurrencyExchangeUpdateSubscriber implements EventSubscriber
{
    public function __construct(
        private readonly NotifyInterface $notify
    )
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
        ];
    }

    /**
     * @throws Exception
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();
        if ($entity instanceof CurrencyExchange) {
            $changeSet = $eventArgs->getEntityChangeSet();
            $messages = $this->getMessageBuyAndSellChanges($entity, $changeSet);

            if ($messageInput = $this->createAndSendMessage($entity, $messages)){
                $this->notify->send($messageInput);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function getMessageBuyAndSellChanges(CurrencyExchange $currencyExchange, array $changeSet): array
    {
        $messages = [];
        if (isset($changeSet['sellRate']) || isset($changeSet['buyRate'])) {
            $oldSell = $changeSet['sellRate'][0] ?? null;
            $newSell = $changeSet['sellRate'][1] ?? null;
            $oldBuy = $changeSet['buyRate'][0] ?? null;
            $newBuy = $changeSet['buyRate'][1] ?? null;

            $changePercentSell = round((($newSell - $oldSell) / $oldSell) * 100, 2);
            if (abs($changePercentSell) >= CurrencyExchange::THRESHOLD_PERCENT){
                $messages[] = $this->generateContentMessage($currencyExchange, $changePercentSell, 'sell');
            }
            $changePercentBuy = round((($newBuy - $oldBuy) / $oldBuy) * 100, 2);
            if (abs($changePercentBuy) >= CurrencyExchange::THRESHOLD_PERCENT) {
                $messages[] = $this->generateContentMessage($currencyExchange, $changePercentBuy, 'buy');
            }
        }
        return $messages;
    }

    /**
     * @throws Exception
     */
    private function generateContentMessage(CurrencyExchange $currencyExchange, float $changePercent, string $type): string
    {
        if ($type == 'sell') {
            $content = "The value of sell has changed to {$changePercent}% on {$currencyExchange->getBank()->getName()}bank";
        } elseif ($type == 'buy') {
            $content =  "The value of buy has changed to {$changePercent}% on {$currencyExchange->getBank()->getName()}bank";
        } else {
            throw new Exception('Not support type');
        }
        return $content;
    }

    #[Pure]
    private function generateTitleMessage(CurrencyExchange $currencyExchange): string
    {
        return "Change {$currencyExchange->getCurrency()->getName()}currency exchange on {$currencyExchange->getBank()->getName()}bank";
    }

    #[Pure]
    private function createAndSendMessage(CurrencyExchange $currencyExchange, array $messages): ?MessageInput
    {
        if (!empty($messages)) {
            $content = implode("\n", $messages);
            $title = $this->generateTitleMessage($currencyExchange);
            return new MessageInput($title, $content);
        }
        return null;
    }
}
