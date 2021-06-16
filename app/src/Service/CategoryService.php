<?php
/**
 * License block.
 */
namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CategoryService.
 */
class CategoryService
{
    private CategoryRepository $categoryRepository;
    private PaginatorInterface $paginator;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create pagination.
     * @param int $page
     *
     * @return PaginationInterface
     */
    public function createPagination(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->categoryRepository->queryAll(),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save.
     *
     * @param Category $category
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Category $category): void
    {
        $this->categoryRepository->save($category);
    }

    /**
     * Delete.
     *
     * @param Category $category
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }

    /**
     * Find one category by Id.
     *
     * @param int $id
     *
     * @return Category|null
     */
    function findOneById(int $id): ?Category
    {
        return $this->categoryRepository->findOneById($id);
    }
}
