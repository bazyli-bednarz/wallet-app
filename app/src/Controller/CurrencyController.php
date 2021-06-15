<?php
/**
 * Currency controller.
 */

namespace App\Controller;

use App\Entity\Currency;
use App\Service\CurrencyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CurrencyController.
 *
 * @Route("/currency")
 */
class CurrencyController extends AbstractController
{
    private CurrencyService $currencyService;

    /**
     * CurrencyController constructor.
     *
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }


    /**
     * Index action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="currency_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->currencyService->createPagination($page);

        return $this->render(
            'currency/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Currency $currency Currency entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="currency_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Currency $currency): Response
    {
        return $this->render(
            'currency/show.html.twig',
            ['currency' => $currency]
        );
    }
}
