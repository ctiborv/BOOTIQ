<?php

namespace App\Repository;

use App\Entity\Watchdog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class WatchdogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Watchdog::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('w')
            ->where('w.something = :value')->setParameter('value', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    
            /**
         * @param Product $product 
         */
        public function saveWatchdog(Watchdog $watchdog)
        {
                $this->getEntityManager()->persist($watchdog);
                $this->getEntityManager()->flush($watchdog);
        }
    
}
