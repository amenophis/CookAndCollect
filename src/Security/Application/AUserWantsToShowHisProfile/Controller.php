<?php

declare(strict_types=1);

namespace App\Security\Application\AUserWantsToShowHisProfile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Controller extends AbstractController
{
    /**
     * @Route("/profile", methods={"GET"}, name="app_security_user_profile")
     */
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('app/security/user_profile.html.twig');
    }
}
