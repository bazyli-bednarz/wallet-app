<?php
/**
 * Necessary includes for currency controller.
 */

namespace App\Controller;

use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for currencies.
 *
 * Class CurrencyController
 * @Route(
 *     "/currency",
 * )
 */
class CurrencyController extends AbstractController
{
    /**
     * Index action.
     *
     * @param CurrencyRepository $repository Currency repository
     *
     * @return Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="currency_index",
     * )
     */
    public function index(CurrencyRepository $repository): Response
    {
        return $this->render(
            'currency/index.html.twig',
            ['data' => $repository->findAll()]
        );
    }

    /**
     * Show currency by ID
     *
     * @param CurrencyRepository $repository Currency repository
     * @param int $id Currency ID
     * @return Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="currency_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     */

    public function show(CurrencyRepository $repository, int $id): Response
    {
        return $this->render(
            'currency/show.html.twig',
            ['item' => $repository->findById($id)]
        );
    }
}
