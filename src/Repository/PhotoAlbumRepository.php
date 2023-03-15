<?php

namespace App\Repository;

use App\Entity\PhotoAlbum;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoAlbum|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoAlbum|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoAlbum[]    findAll()
 * @method PhotoAlbum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoAlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoAlbum::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PhotoAlbum $entity, bool $flush = true): void
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
    public function remove(PhotoAlbum $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function initiateAlbum(): PhotoAlbum
    {
        return (new PhotoAlbum())
            ->setCreatedAt(Carbon::now()->toDateTimeImmutable())
            ->setUpdatedAt(Carbon::now()->toDateTimeImmutable());
    }

    // /**
    //  * @return PhotoAlbum[] Returns an array of PhotoAlbum objects
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

    /*
    public function findOneBySomeField($value): ?PhotoAlbum
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
