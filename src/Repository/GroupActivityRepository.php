<?php

namespace App\Repository;

use App\Entity\GroupActivity;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupActivity[]    findAll()
 * @method GroupActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupActivity::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(GroupActivity $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(GroupActivity $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findClosestUpcomingActivity(): ?GroupActivity
    {
        return $this->createQueryBuilder('g')
            ->orderBy('g.startDate', 'DESC')
            ->where('g.startDate >= :today')
            ->orWhere('g.endDate >= :today')
            ->setParameter('today', new \DateTime('today midnight'))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getGroupActivityDescending()
    {
        return $this->createQueryBuilder('g')
            ->where('g.startDate >= :today')
            ->orWhere('g.endDate >= :today')
            ->setParameter('today', new \DateTime('today midnight'))
            ->orderBy('g.startDate', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return GroupActivity[] Returns an array of GroupActivity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupActivity
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
