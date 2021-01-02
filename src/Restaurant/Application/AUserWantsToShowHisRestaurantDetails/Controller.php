<?php

declare(strict_types=1);

namespace App\Restaurant\Application\AUserWantsToShowHisRestaurantDetails;

use App\Security\Infrastructure\Symfony\Security\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Restaurant\Domain\UseCase\AUserWantsToShowHisRestaurantDetails;

class Controller extends AbstractController
{
    use HandleTrait {
        handle as handleInput;
    }

    public function __construct(MessageBusInterface $useCaseBus)
    {
        $this->messageBus = $useCaseBus;
    }

    /**
     * @Route("/restaurant", methods={"GET"}, name="app_restaurant_details")
     */
    public function __invoke(User $user): Response
    {
        $output = $this->handle(new AUserWantsToShowHisRestaurantDetails\Input($user->getId()));

        return $this->render('app/restaurant/details.html.twig', [
            'restaurant' => $output->getRestaurant(),
        ]);
    }

    private function handle(AUserWantsToShowHisRestaurantDetails\Input $input): AUserWantsToShowHisRestaurantDetails\Output
    {
        return $this->handleInput($input);
    }
}
