<?php

declare(strict_types=1);

namespace App\Restaurant\Application\AUserWantsToUpdateHisRestaurantName;

use App\Restaurant\Domain\Data\Repository\Restaurants;
use App\Restaurant\Domain\UseCase\AUserWantsToUpdateHisRestaurantName;
use App\Security\Infrastructure\Symfony\Security\User;
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
     * @Route("/restaurant/update-name", methods={"GET", "POST"}, name="app_restaurant_update_name")
     */
    public function __invoke(Request $request, User $user, Restaurants $restaurants): Response
    {
        $restaurant = $restaurants->findByOwner($user->getId());
        if (null === $restaurant) {
            return $this->redirectToRoute('app_restaurant_details');
        }

        $formData                 = new FormDto();
        $formData->restaurantName = $restaurant->getName();

        $form = $this->createForm(Form::class, $formData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $input = new AUserWantsToUpdateHisRestaurantName\Input($restaurant->getId(), $formData->restaurantName);
            $this->useCaseBus->dispatch($input);

            return $this->redirectToRoute('app_restaurant_details');
        }

        return $this->render('app/restaurant/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
