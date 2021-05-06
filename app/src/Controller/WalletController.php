<?php
/**
 * Necessary includes for wallet controller.
 */

namespace App\Controller;

use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for wallets.
 *
 * Class WalletController
 * @Route(
 *     "/wallet",
 * )
 */
class WalletController extends AbstractController
{
    /**
     * Index action.
     *
     * @param WalletRepository $repository Wallet repository
     *
     * @return Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="wallet_index",
     * )
     */
    public function index(WalletRepository $repository): Response
    {
        return $this->render(
            'wallet/index.html.twig',
            ['data' => $repository->findAll()]
        );
    }

    /**
     * Show wallet by ID
     *
     * @param WalletRepository $repository Wallet repository
     * @param int $id Wallet ID
     * @return Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="wallet_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     */

    public function show(WalletRepository $repository, int $id): Response
    {
        return $this->render(
            'wallet/show.html.twig',
            ['item' => $repository->findById($id)]
        );
    }
}
