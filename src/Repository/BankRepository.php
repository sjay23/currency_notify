<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Bank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bank::class);
    }

    public function findById(int $id): ?Bank
    {
        return $this->findOneBy(['id' => $id]);
    }
}
