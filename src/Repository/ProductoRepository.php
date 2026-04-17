<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Producto>
 */
class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

        /**
        * @return Producto[] Returns an array of Producto objects
        */
        public function findByName($value): array
       {
            return $this->createQueryBuilder('p')
                ->andWhere('LOWER(p.nombre) LIKE :val')
                ->setParameter('val', '%' . strtolower($value) . '%')
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        }

         public function findByCategoryStock($value): string
        {
              return $this->createQueryBuilder('p')
                  ->join('p.lotes', 'l')
                  ->andWhere('l.cantidad > 0')
                  ->orderBy('p.id', 'ASC')
                  ->getQuery()
                  ->getResult();
    }
}
