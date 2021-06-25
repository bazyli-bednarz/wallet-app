<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Operation;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * OperationRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    /**
     * Save record.
     *
     * @param Operation $operation
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Operation $operation): void
    {
        $this->_em->persist($operation);
        $this->_em->flush();
    }

    /**
     * Remove record.
     *
     * @param Operation $operation Operation
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Operation $operation): void
    {
        $this->_em->remove($operation);
        $this->_em->flush();
    }

    /**
     * Query all records.
     *
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial operation.{id, time, value, name}',
                'partial category.{id, name}',
                'partial tags.{id, name}',
                'wallet'
            )
            ->join('operation.category', 'category')
            ->join('operation.wallet', 'wallet')
            ->leftJoin('operation.tags', 'tags')
            ->orderBy('operation.time', 'DESC');

        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return QueryBuilder
     */
    public function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('operation');
    }

    /**
     * Query by author.
     *
     * @param User  $user
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);
        $queryBuilder->andWhere('wallet.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Apply to filters list.
     *
     * @param QueryBuilder $queryBuilder
     * @param array        $filters
     *
     * @return QueryBuilder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (isset($filters['tag']) && $filters['tag'] instanceof Tag) {
            $queryBuilder->andWhere('tags IN (:tag)')
                ->setParameter('tag', $filters['tag']);
        }

        if (isset($filters['wallet']) && $filters['wallet'] instanceof Wallet) {
            $queryBuilder->andWhere('wallet = :wallet')
                ->setParameter('wallet', $filters['wallet']);
        }

        return $queryBuilder;
    }
}
