<?php
/**
 * Operation controller.
 */

namespace App\Controller;

use App\Entity\Operation;
use App\Entity\Wallet;
use App\Form\OperationType;
use App\Repository\WalletRepository;
use App\Service\OperationService;
use App\Service\WalletService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Security\Core\Security;

/**
 * Class OperationController.
 *
 * @Route("/operation")
 *
 * @IsGranted("ROLE_USER")
 */
class OperationController extends AbstractController
{
    private OperationService $operationService;
    private Security $security;

    /**
     * OperationController constructor.
     * @param OperationService $operationService
     */
    public function __construct(OperationService $operationService, Security $security)
    {
        $this->operationService = $operationService;
        $this->security = $security;
    }


    /**
     * Index action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="operation_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');
        $filters['wallet_id'] = $request->query->getInt('filters_wallet_id');

        $page = $request->query->getInt('page', 1);
        $pagination = $this->operationService->createPagination($page, $this->getUser(), $filters);

        return $this->render(
            'operation/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Operation $operation Operation entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="operation_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     * @IsGranted(
     *     "VIEW",
     *     subject="operation",
     * )
     */
    public function show(Operation $operation): Response
    {
        return $this->render(
            'operation/show.html.twig',
            ['operation' => $operation]
        );
    }

    /**
     * Create operation and update wallet balance.
     *
     * @param Request $request
     * @param WalletService $walletService
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="operation_create",
     * )
     */
    public function create(Request $request, WalletService $walletService): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $wallet = $walletService->findOneById($operation->getWallet()->getId());
            $walletBalance = $wallet->getBalance();
            $value = $form['value']->getData();
            if ($walletBalance+$value >= 0) {
                $wallet->setBalance($walletBalance+$value);
                $operation->setWallet($wallet);
                $this->operationService->save($operation);

                $walletService->save($wallet, $this->security->getUser());
                $this->addFlash('success', 'message_created_successfully');
            }
            else {
                $this->addFlash('warning', 'message_value_too_low');
            }

            return $this->redirectToRoute('operation_index');
        }

        return $this->render(
            'operation/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request   $request   HTTP request
     * @param Operation $operation Operation entity
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
     *     name="operation_edit",
     * )
     *
     * @IsGranted(
     *     "EDIT",
     *     subject="operation",
     * )
     */
    public function edit(Request $request, Operation $operation, WalletService $walletService): Response
    {
        $operationOld = clone $operation;
        $valueOld = $operationOld->getValue();
        $walletOld = clone $walletService->findOneById($operationOld->getWallet()->getId());
        $walletOldId = $walletOld->getId();
        $walletBalanceOld = $walletOld->getBalance();

        $form = $this->createForm(OperationType::class, $operation, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $walletNew = $walletService->findOneById($form['wallet']->getData()->getId());
            if ($walletNew->getId() === $walletOldId) {
                $walletBalance = $walletNew->getBalance();
                $valueNew = $form['value']->getData();
                if ($walletBalance + $valueNew - $valueOld >= 0)
                {
                    $walletNew->setBalance($walletBalance + $valueNew - $valueOld);
                    $this->operationService->save($operation);
                    $this->addFlash('success', 'message_created_successfully');
                }
                else
                {
                    $this->addFlash('warning', 'message_value_too_low');
                }
            }
            else
            {
                $walletBalanceNew = $walletNew->getBalance();
                $valueNew = $form['value']->getData();
                if (($walletBalanceOld - $valueOld < 0) || ($walletBalanceNew + $valueNew < 0))
                {
                    $this->addFlash('warning', 'message_value_too_low');
                }
                else
                {
                    $walletNew->setBalance($walletBalanceNew + $valueNew);
                    $walletService->findOneById($walletOldId)->setBalance($walletBalanceOld - $valueOld);
                    $operation->setWallet($walletNew);
                    $this->operationService->save($operation);
                    $this->addFlash('success', 'message_created_successfully');
                }
            }

            return $this->redirectToRoute('operation_index');
        }

        return $this->render(
            'operation/edit.html.twig',
            [
                'form' => $form->createView(),
                'operation' => $operation,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request   $request   HTTP request
     * @param Operation $operation Operation entity
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
     *     name="operation_delete",
     * )
     *
     * @IsGranted(
     *     "DELETE",
     *     subject="operation",
     * )
     */
    public function delete(Request $request, Operation $operation, WalletService $walletService): Response
    {
        $operationOld = clone $operation;
        $valueOld = $operationOld->getValue();
        $walletOld = clone $walletService->findOneById($operationOld->getWallet()->getId());
//        $walletOldId = $walletOld->getId();
        $walletBalanceOld = $walletOld->getBalance();

        $form = $this->createForm(FormType::class, $operation, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($walletBalanceOld - $valueOld >= 0)
            {
                $operation->getWallet()->setBalance($walletBalanceOld - $valueOld);
                $this->operationService->delete($operation);
                $this->addFlash('success', 'message_deleted_successfully');
            }
            else
            {
                $this->addFlash('warning', 'message_value_too_low_delete');
            }
            return $this->redirectToRoute('operation_index');
        }

        return $this->render(
            'operation/delete.html.twig',
            [
                'form' => $form->createView(),
                'operation' => $operation,
            ]
        );
    }
}
