<?php

namespace App\Repository;

use App\Entity\Bibliotheque;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of User objects
     */
       public function getBibliothequeWithUser(User $user, Bibliotheque $bibliotheque) {

        return $this->createQueryBuilder('u')
            ->addSelect('b')
            ->leftJoin('u.bibliotheque', 'b')
            ->andWhere('u.bibliotheque_id = :b.id')
            ->setParameter('b.id', $bibliotheque)
            ->getQuery()
            ->getResult()
        ;
       }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
