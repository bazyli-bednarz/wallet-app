<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Service;

use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\User;

/**
 * Class WalletService.
 */
class WalletService
{
    private WalletRepository $walletRepository;
    private PaginatorInterface $paginator;

    /**
     * WalletService constructor.
     *
     * @param WalletRepository   $walletRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(WalletRepository $walletRepository, PaginatorInterface $paginator)
    {
        $this->walletRepository = $walletRepository;
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
            $this->walletRepository->queryByAuthor($user),
            $page,
            WalletRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save record.
     *
     * @param Wallet $wallet
     * @param User   $user
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Wallet $wallet, User $user): void
    {
        if (null === $wallet->getId()) {
            $wallet->setAuthor($user);
        }
        $this->walletRepository->save($wallet);
    }

    /**
     * Delete.
     *
     * @param Wallet $wallet
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Wallet $wallet): void
    {
        $this->walletRepository->delete($wallet);
    }

    /**
     * Find wallet by ID.
     *
     * @param int $id
     *
     * @return Wallet|null
     */
    public function findOneById(int $id): ?Wallet
    {
        return $this->walletRepository->findOneById($id);
    }
}
