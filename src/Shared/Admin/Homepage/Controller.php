<?php

declare(strict_types=1);

namespace App\Shared\Admin\Homepage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="admin_homepage")
     */
    public function __invoke(Request $request): Response
    {
        return $this->render('admin/homepage.html.twig');
    }
}
