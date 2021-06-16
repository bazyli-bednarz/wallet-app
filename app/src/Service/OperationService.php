<?php
/**
 * Operation service.
 */
namespace App\Service;

use App\Entity\Operation;
use App\Entity\User;
use App\Repository\OperationRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class OperationService
 */
class OperationService
{
    private OperationRepository $operationRepository;
    private PaginatorInterface $paginator;

    /**
     * OperationService constructor.
     *
     * @param OperationRepository $operationRepository
     * @param PaginatorInterface  $paginator
     */
    public function __construct(OperationRepository $operationRepository, PaginatorInterface $paginator)
    {
        $this->operationRepository = $operationRepository;
        $this->paginator = $paginator;
    }

    /**
     * Pagination.
     *
     * @param int  $page
     * @param User $user
     *
     * @return PaginationInterface
     */
    public function createPagination(int $page, User $user): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->operationRepository->queryByAuthor($user),
            $page,
            OperationRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save.
     *
     * @param Operation $operation
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Operation $operation): void
    {
        $this->operationRepository->save($operation);
    }

    /**
     * Delete.
     *
     * @param Operation $operation
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Operation $operation): void
    {
        $this->operationRepository->delete($operation);
    }
}
