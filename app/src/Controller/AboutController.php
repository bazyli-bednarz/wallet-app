<?php
/**
 * About controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AboutController.
 *
 * @Route("/about")
 */
class AboutController extends AbstractController
{
    /**
     * Index action.
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="about_index",
     * )
     *
     */
    public function index(): Response
    {
        return $this->render(
            'about/index.html.twig',
        );
    }
}
