<?php
/**
 * Operation controller.
 */

namespace App\Controller;

use App\Entity\Operation;
use App\Form\OperationType;
use App\Repository\OperationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

/**
 * Class OperationController.
 *
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    private OperationRepository $operationRepository;

    private PaginatorInterface $paginator;

    /**
     * OperationController constructor.
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
        $pagination = $this->paginator->paginate(
            $this->operationRepository->queryAll(),
            $request->query->getInt('page', 1),
            OperationRepository::PAGINATOR_ITEMS_PER_PAGE
        );

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
     */
    public function show(Operation $operation): Response
    {
        return $this->render(
            'operation/show.html.twig',
            ['operation' => $operation]
        );
    }

    /**
     * @param Request $request
     * @param OperationRepository $operationRepository
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="operation_create",
     *
     * )
     */
    public function create(Request $request, OperationRepository $operationRepository): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $operationRepository->save($operation);
            $this->addFlash('success', 'message_created_successfully');

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
     * @param Request             $request             HTTP request
     * @param Operation           $operation           Operation entity
     * @param OperationRepository $operationRepository Operation repository
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
     */
    public function edit(Request $request, Operation $operation, OperationRepository $operationRepository): Response
    {
        $form = $this->createForm(OperationType::class, $operation, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $operationRepository->save($operation);
            $this->addFlash('success', 'message_updated_successfully');

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
     * @param Request             $request             HTTP request
     * @param Operation           $operation           Operation entity
     * @param OperationRepository $operationRepository Operation repository
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
     */
    public function delete(Request $request, Operation $operation, OperationRepository $operationRepository): Response
    {
        $form = $this->createForm(FormType::class, $operation, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $operationRepository->delete($operation);
            $this->addFlash('success', 'message_deleted_successfully');

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
