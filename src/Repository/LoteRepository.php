<?php

namespace App\Repository;

use App\Entity\Lote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lote>
 */
class LoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lote::class);
    }

        /**
         * @return Lote[] Returns an array of Lote objects
        */
       public function findProductsWithStock (): array
        {
            return $this->createQueryBuilder('l')
                ->select('p.id, p.nombre, p.codigo, p.categoria')
                ->join('l.producto', 'p')
                ->andWhere('l.cantidad > 0')
                ->distinct()
                ->orderBy('p.nombre', 'ASC')
                ->getQuery()
               ->getResult();
       }

    //    public function findOneBySomeField($value): ?Lote
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
