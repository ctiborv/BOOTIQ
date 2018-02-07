<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
   */
    
        public function getProducts()
        {
                return $this->findAll();
        }

        /**
         * @param string $id 
         * @return null|Product první článek, který odpovídá URL nebo null při neúspěchu
         */
        public function getProduct($id)
        {
                return $this->find($id);
        }

        /**
         * @param Product $product 
         */
        public function saveProduct(Product $product)
        {
                $this->getEntityManager()->persist($product);
                $this->getEntityManager()->flush($product);
        }

        /**
         * @param integer $id
         */
        public function removeProduct($id)
        {
                if (($product = $this->getProduct($id))) {
                        $this->getEntityManager()->remove($product);
                        $this->getEntityManager()->flush();
                }
        }
        
        public function getColumnValue($column,$id){
            $conn = $this->getEntityManager()->getConnection();
            
            $sql = 
                'SELECT p.'.$column.' 
                FROM product p  where id=:id '
            ;
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $id]);

            $result = $stmt->fetch();
            return ($result[$column]);
        }
    
        
}
