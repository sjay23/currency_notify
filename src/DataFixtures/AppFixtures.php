<?php

namespace App\DataFixtures;

use App\Entity\Bank;
use App\Entity\Currency;
use App\Entity\CurrencyExchange;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $banksName = ['Privat24', 'Mono'];
        $currenciesCode = ['USD', 'EUR'];

        $banks = [];
        foreach ($banksName as $bankName) {
            $banks[] = $this->createBank($manager, $bankName);
        }

        $currencies = [];
        foreach ($currenciesCode as $currencyCode) {
            $currencies[] = $this->createCurrency($manager, $currencyCode);
        }

        foreach ($banks as $bank) {
            foreach ($currencies as $currency) {
                $this->createCurrencyExchange($manager, $bank, $currency);
            }
        }
    }

    private function createBank(ObjectManager $manager, string $bank): Bank
    {
        $bank = new Bank($bank);
        $manager->persist($bank);
        $manager->flush();
        return $bank;
    }

    private function createCurrency(ObjectManager $manager, string $currency): Currency
    {
        $currency = new Currency($currency);
        $manager->persist($currency);
        $manager->flush();
        return $currency;
    }
    
    private function createCurrencyExchange(ObjectManager $manager, Bank $bank, Currency $currency): void
    {
        $currencyExchange = new CurrencyExchange($currency, $bank, 0, 0);
        $manager->persist($currencyExchange);
        $manager->flush();
    }
}
