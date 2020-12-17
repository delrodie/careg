<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    public function findByRegion($region)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('a')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->innerJoin('p.activite', 'a')
            ->innerJoin('p.groupe', 'g')
            ->innerJoin('g.district', 'd')
            ->innerJoin('d.region', 'r')
            ->where('r.id = :region')
            ->andWhere(':date BETWEEN a.dateDebut AND a.dateFin')
            ->setParameters([
                'region' => $region,
                'date' => date('Y-m-d', time())
            ])
            ->getQuery()->getResult()
            ;
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
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
    public function findOneBySomeField($value): ?Participant
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
