<?php

namespace App\Repository;

use App\Entity\Bibliotheque;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bibliotheque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bibliotheque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bibliotheque[]    findAll()
 * @method Bibliotheque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BibliothequeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bibliotheque::class);
    }

    /**
     * @return Bibliotheque[] Returns an array of Bibliotheque objects
     */
        public function getBibliothequeWithUser(Bibliotheque $bibliotheque) {

        return $this->createQueryBuilder('b')
            ->addSelect('u')
            ->leftJoin('b.id', 'u')
            ->andWhere('b.id = u.id')
            ->setParameter('u.id', $bibliotheque)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Bibliotheque
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
