<?php

declare(strict_types=1);

namespace App\Application\Homepage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="homepage")
     */
    public function __invoke(Request $request): Response
    {
        return $this->render('app/homepage.html.twig');
    }
}
