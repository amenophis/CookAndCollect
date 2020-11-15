<?php

declare(strict_types=1);

namespace App\Security\Application\AUserWantsToLogout;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/logout", methods={"GET", "POST"}, name="security_user_logout")
     */
    public function __invoke(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
