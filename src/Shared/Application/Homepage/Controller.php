<?php

declare(strict_types=1);

namespace App\Shared\Application\Homepage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="app_homepage")
     */
    public function __invoke(Request $request): Response
    {
        return $this->render('app/homepage.html.twig');
    }
}
