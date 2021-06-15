<?php
/**
 * License block.
 */
namespace App\Service;

use App\Repository\CurrencyRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CurrencyService.
 */
class CurrencyService
{
    private CurrencyRepository $currencyRepository;
    private PaginatorInterface $paginator;

    /**
     * CurrencyService constructor.
     *
     * @param CurrencyRepository $currencyRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(CurrencyRepository $currencyRepository, PaginatorInterface $paginator)
    {
        $this->currencyRepository = $currencyRepository;
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
            $this->currencyRepository->queryAll(),
            $page,
            CurrencyRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
