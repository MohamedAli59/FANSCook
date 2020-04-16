<?php

namespace App\Repository;

use App\Entity\Preparations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Preparations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Preparations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Preparations[]    findAll()
 * @method Preparations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreparationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Preparations::class);
    }

    // /**
    //  * @return Preparations[] Returns an array of Preparations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /**
     * @return Preparations[] Returns an array of Preparations objects
     */

    public function getPreparationOrderByOrdre($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Preparations p
            WHERE p.recettes = :id
            ORDER BY p.ordres ASC'
        )->setParameter('id', $id);

        // returns an array of Product objects
        return $query->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Preparations
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
