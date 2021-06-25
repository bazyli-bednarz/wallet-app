<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
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
    private CategoryService $categoryService;
    private TagService $tagService;
    private WalletService $walletService;

    /**
     * OperationService constructor.
     * @param OperationRepository $operationRepository
     * @param PaginatorInterface  $paginator
     * @param CategoryService     $categoryService
     * @param TagService          $tagService
     * @param WalletService       $walletService
     */
    public function __construct(OperationRepository $operationRepository, PaginatorInterface $paginator, CategoryService $categoryService, TagService $tagService, WalletService $walletService)
    {
        $this->operationRepository = $operationRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
        $this->walletService = $walletService;
    }

    /**
     * Pagination.
     *
     * @param int   $page
     * @param User  $user
     * @param array $filters
     *
     * @return PaginationInterface
     */
    public function createPagination(int $page, User $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->operationRepository->queryByAuthor($user, $filters),
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

    /**
     * Prepare filters.
     *
     * @param array $filters
     *
     * @return array
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['category_id']) && is_numeric($filters['category_id'])) {
            $category = $this->categoryService->findOneById(
                $filters['category_id']
            );
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        if (isset($filters['tag_id']) && is_numeric($filters['tag_id'])) {
            $tag = $this->tagService->findOneById($filters['tag_id']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        if (isset($filters['wallet_id']) && is_numeric($filters['wallet_id'])) {
            $wallet = $this->walletService->findOneById(
                $filters['wallet_id']
            );
            if (null !== $wallet) {
                $resultFilters['wallet'] = $wallet;
            }
        }

        return $resultFilters;
    }
}
