<?php
/**
 * Wallet controller.
 */

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletType;
use App\Repository\WalletRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

/**
 * Class WalletController.
 *
 * @Route("/wallet")
 */
class WalletController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request          HTTP request
     * @param WalletRepository   $walletRepository wallet repository
     * @param PaginatorInterface $paginator        Paginator
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="wallet_index",
     * )
     */
    public function index(Request $request, WalletRepository $walletRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $walletRepository->queryAll(),
            $request->query->getInt('page', 1),
            WalletRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'wallet/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Wallet $wallet Wallet entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="wallet_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Wallet $wallet): Response
    {
        return $this->render(
            'wallet/show.html.twig',
            ['wallet' => $wallet]
        );
    }

    /**
     * Create action.
     *
     * @param Request          $request          HTTP request
     * @param WalletRepository $walletRepository Wallet repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="wallet_create",
     * )
     */
    public function create(Request $request, WalletRepository $walletRepository): Response
    {
        $wallet = new Wallet();
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $walletRepository->save($wallet);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request          $request          HTTP request
     * @param Wallet           $wallet           Wallet entity
     * @param WalletRepository $walletRepository Wallet repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="wallet_edit",
     * )
     */
    public function edit(Request $request, Wallet $wallet, WalletRepository $walletRepository): Response
    {
        $form = $this->createForm(WalletType::class, $wallet, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $walletRepository->save($wallet);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/edit.html.twig',
            [
                'form' => $form->createView(),
                'wallet' => $wallet,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request          $request          HTTP request
     * @param Wallet           $wallet           Wallet entity
     * @param WalletRepository $walletRepository Wallet repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="wallet_delete",
     * )
     */
    public function delete(Request $request, Wallet $wallet, WalletRepository $walletRepository): Response
    {
        if ($wallet->getOperations()->count()) {
            $this->addFlash('warning', 'message_category_contains_tasks');

            return $this->redirectToRoute('wallet_index');
        }

        $form = $this->createForm(FormType::class, $wallet, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $walletRepository->delete($wallet);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/delete.html.twig',
            [
                'form' => $form->createView(),
                'wallet' => $wallet,
            ]
        );
    }
}
