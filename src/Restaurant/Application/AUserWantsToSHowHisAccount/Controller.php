<?php

declare(strict_types=1);

namespace App\Restaurant\Application\AUserWantsToSHowHisAccount;

use App\Restaurant\Domain\UseCase\AUserWantsToCreateARestaurant;
use App\Security\Infrastructure\Symfony\Security\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    private MessageBusInterface $useCaseBus;

    public function __construct(MessageBusInterface $useCaseBus)
    {
        $this->useCaseBus = $useCaseBus;
    }

    /**
     * @Route("/account", methods={"GET"}, name="app_user_account")
     * @IsGranted("ROLE_USER")
     */
    public function __invoke(Request $request, User $user): Response
    {
    }
}
