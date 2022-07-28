<?php

namespace App\Repository;

use App\Entity\Categories;
use App\Entity\Niveaux;
use App\Entity\Publications;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Publications>
 *
 * @method Publications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publications[]    findAll()
 * @method Publications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publications::class);
    }

    public function add(Publications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Publications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Undocumented function
     *
     * @param Publications $publication
     * @param Categories $categories
     * @return array
     */
    public function findCategorie($publication): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.categorie', 'c')
            ->Where('p.id = :p_id')
            ->setParameter('p_id', $publication)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();


        //$result = $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Publications[] Returns an array of Publications objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Publications
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}