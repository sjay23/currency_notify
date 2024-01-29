<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\CurrencyExchangeInput;
use App\Entity\Bank;
use App\Repository\BankRepository;
use App\Repository\CurrencyExchangeRepository;
use App\Repository\CurrencyRepository;
use App\Service\Parser\ParserFactoryInterface;

class CurrencyExchangeService
{
    public function __construct(
        private readonly BankRepository $bankRepository,
        private readonly CurrencyRepository $currencyRepository,
        private readonly CurrencyExchangeRepository $currencyExchangeRepository,
        private readonly ParserFactoryInterface $parserFactory,
    )
    {
    }

    public function getActuallyCurrencyExchanges(): array
    {
        $banks = $this->getBanks();
        $results = [];
        foreach ($banks as $bank) {
            /* @var Bank $bank */
            $bankName = $bank->getName();
            $parser = $this->parserFactory->createParser($bankName);
            $results[$bank->getId()] = $parser->getData();
        }
        return $results;
    }

    public function saveCurrencyExchanges(array $actuallyCurrenciesByBank): void
    {
        foreach ($actuallyCurrenciesByBank as $bankId => $currencyExchangeInputs) {
            $bank = $this->bankRepository->findById($bankId);
            foreach ($currencyExchangeInputs as $currencyExchangeInput) {
                /**@var CurrencyExchangeInput $currencyExchangeInput */
                $this->saveCurrencyExchange($bank, $currencyExchangeInput);
            }
        }
    }

    private function saveCurrencyExchange(Bank $bank, CurrencyExchangeInput $currencyExchangeInput): void
    {
        $currency = $this->currencyRepository->findByCode($currencyExchangeInput->getCurrencyCode());
        $currencyExchange = $this->currencyExchangeRepository->findOneByBankAndCurrency($bank, $currency);
        if ($currencyExchange) {
            $currencyExchange->setBuyRate(round($currencyExchangeInput->getBuyRate(), 4));
            $currencyExchange->setSellRate(round($currencyExchangeInput->getSellRate(), 4));
            $this->currencyExchangeRepository->save($currencyExchange);
        }
    }

    private function getBanks(): array
    {
        return $this->bankRepository->findAll();
    }
}
