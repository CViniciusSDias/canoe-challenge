<?php

namespace App\Repository;

use App\Entity\Fund;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Override;

/**
 * @extends ServiceEntityRepository<Fund>
 *
 * @method Fund|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fund|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fund[]    findAll()
 */
class FundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fund::class);
    }

    public function add(Fund $fund): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($fund);
        $entityManager->flush();
    }

    /**
     * @return Fund[]
     */
    #[Override]
    public function findBy(array $criteria, ?array $orderBy = null, $limit = 10, $offset = 0): array
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Fund::class, 'fund');

        $sql = <<<SQL
        SELECT id, name, start_year, manager_id, aliases
        FROM fund
        WHERE 1 = 1
        SQL;

        $parameters = [];

        if (isset($criteria['name'])) {
            $sql .= ' AND name = :name';
            $parameters['name'] = $criteria['name'];
        }

        if (isset($criteria['startYear'])) {
            $sql .= ' AND start_year = :startYear';
            $parameters['startYear'] = $criteria['startYear'];
        }

        if (isset($criteria['managerId'])) {
            $sql .= ' AND manager_id = :managerId';
            $parameters['managerId'] = $criteria['managerId'];
        }

        if (isset($criteria['alias'])) {
            $sql .= ' AND aliases ?? :alias';
            $parameters['alias'] = $criteria['alias'];
        }

        $sql .= ' LIMIT :limit OFFSET :offset';
        $parameters['limit'] = $limit;
        $parameters['offset'] = $offset;

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameters($parameters);

        return $query->getResult();
    }

    public function doesFundAlreadyExist(string $name, array $aliases, ?string $managerId): bool
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addScalarResult('count', 'count');

        $sql = <<<SQL
        SELECT COUNT(*) AS count
        FROM fund
        WHERE name = :name
        AND manager_id::text = :managerId
        OR aliases ??| array[:aliases]
        SQL;
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameter('name', $name);
        $query->setParameter('aliases', $aliases);
        $query->setParameter('managerId', $managerId);

        return $query->getSingleScalarResult() > 0;
    }
}
