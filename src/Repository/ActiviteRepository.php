<?php

namespace App\Repository;

use App\Entity\Activite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Activite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activite[]    findAll()
 * @method Activite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activite::class);
    }

    /**
     * @param $activite
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findActivite($activite)
    {
        return $this->createQueryBuilder('a')
            ->where('a.id = :activite')
            ->setParameter('activite', $activite)
            ;
    }

    /**
     * Activité encours pour admin
     *
     * @return int|mixed|string
     */
    public function findEncours()
    {
        return $this->createQueryBuilder('a')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->innerJoin('a.groupe', 'g')
            ->innerJoin('g.district', 'd')
            ->innerJoin('d.region', 'r')
            ->where(':date BETWEEN a.dateDebut AND a.dateFin')
            ->setParameter('date', date('Y-m-d', time()))
            ->getQuery()->getResult()
            ;
    }

    public function findByRegion($region)
    {
        return $this->createQueryBuilder('a')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('r')
            ->leftJoin('a.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('d.region', 'r')
            ->where('r.id = :region')
            ->setParameter('region', $region)
            ->getQuery()->getResult()
            ;
    }

    /**
     * La liste des activités encours en fonction du groupe district ou region
     *
     * @param null $groupe
     * @param null $district
     * @param null $region
     * @return int|mixed|string
     */
    public function findEncoursBy($groupe = null, $district = null, $region = null)
    {
        $q = $this->createQueryBuilder('a')->addSelect('g');
        if ($groupe){
            $q->leftJoin('a.groupe', 'g')
                ->where('g.id = :groupe')
                ->andWhere(':date BETWEEN a.dateDebut AND a.dateFin')
                ->setParameters([
                    'groupe' => $groupe,
                    'date' => date('Y-m-d', time())
                ])
                ;
        }

        return $q->getQuery()->getResult();
    }

    // /**
    //  * @return Activite[] Returns an array of Activite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Activite
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
