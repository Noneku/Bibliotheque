<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Category;
use App\Entity\Bibliotheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    //**
    //  * @return Livre[] Returns an array of Livre objects
    //  */

    public function getCategorywithLivre(Category $category) {

        return $this->createQueryBuilder('l')
            ->addSelect('c')
            ->leftJoin('l.category', 'c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $category)
            ->addSelect('b')
            ->leftJoin('l.bibliotheque', 'b')
            ->andWhere('b.id = :val')
            ->setParameter('val', $bibliotheque)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
