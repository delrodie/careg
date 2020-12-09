<?php

namespace App\Repository;

use App\Entity\Sygesca\Groupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Groupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Groupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Groupe[]    findAll()
 * @method Groupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groupe::class);
    }

    public function findByScout($groupe)
    {
        return $this->createQueryBuilder('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('g.id = :groupe')
            ->setParameter('groupe', $groupe)
            ->getQuery()->getSingleResult()
            ;
    }
}