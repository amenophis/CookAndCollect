<?php

declare(strict_types=1);

namespace App\Restaurant\Application\AUserWantsToCreateARestaurant;

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
     * @Route("/restaurant/register", methods={"GET", "POST"}, name="app_restarurant_register")
     * @IsGranted("ROLE_USER")
     */
    public function __invoke(Request $request, User $user): Response
    {
        $form = $this->createForm(Form::class, $formData = new FormDto());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $input = new AUserWantsToCreateARestaurant\Input($user->getId(), $formData->restaurantName);
            $this->useCaseBus->dispatch($input);

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('app/restaurant/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
