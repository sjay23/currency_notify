<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Bank;
use App\Entity\Currency;
use App\Entity\CurrencyExchange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CurrencyExchangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyExchange::class);
    }

    public function save(CurrencyExchange $currencyExchange)
    {
        $this->_em->persist($currencyExchange);
        $this->_em->flush();
    }
    
    public function findOneByBankAndCurrency(Bank $bank, Currency $currency): ?CurrencyExchange
    {
        return $this->findOneBy([
            'bank' => $bank->getId(),
            'currency' => $currency->getId()
        ]);
    }
}
