<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UserService.
 */
class UserService
{
    private UserRepository $userRepository;
    private PaginatorInterface $paginator;

    /**
     * UserService constructor.
     *
     * @param UserRepository   $userRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(UserRepository $userRepository, PaginatorInterface $paginator)
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
    }

    /**
     * Pagination.
     *
     * @param int  $page
     *
     * @return PaginationInterface
     */
    public function createPagination(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save record.
     *
     * @param User $user
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

//    /**
//     * Delete.
//     *
//     * @param User $user
//     *
//     * @throws ORMException
//     * @throws OptimisticLockException
//     */
//    public function delete(User $user): void
//    {
//        $this->userRepository->delete($user);
//    }

    /**
     * Find user by ID.
     *
     * @param int $id
     *
     * @return User|null
     */
    public function findOneById(int $id): ?User
    {
        return $this->userRepository->findOneById($id);
    }
}
