<?php
/**
 * Operation controller.
 */

namespace App\Controller;

use App\Entity\Operation;
use App\Repository\OperationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OperationController.
 *
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    /**
     * Index action
     *
     * @param Request $request
     * @param OperationRepository $operationRepository
     * @param PaginatorInterface $paginator
     *
     * @return Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="operation_index",
     * )
     */
    public function index(Request $request, OperationRepository $operationRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $operationRepository->queryAll(),
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
}
