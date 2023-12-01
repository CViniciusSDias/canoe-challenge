<?php

namespace App\Repository;

use App\Entity\FundManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FundManager>
 *
 * @method FundManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method FundManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method FundManager[]    findAll()
 * @method FundManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FundManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FundManager::class);
    }

    public function paginated(int $offset): Paginator
    {
        $query = $this->createQueryBuilder('fund_manager')
            ->setMaxResults(10)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

//    /**
//     * @return FundManager[] Returns an array of FundManager objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FundManager
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
