<?php

declare(strict_types=1);

namespace App\Security\Application\AUserWantsToActivateHisAccount;

use App\Security\Domain\UseCase\AUserWantsToActivateHisAccount;
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
     * @Route("/user/{userId}/activate/{activationToken}", methods={"GET", "POST"}, name="app_user_activate")
     */
    public function __invoke(Request $request, string $userId, string $activationToken): Response
    {
        $form = $this->createForm(Form::class, $formData = new FormDto());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $input = new AUserWantsToActivateHisAccount\Input($userId, $activationToken, $formData->plainPassword);
            $this->useCaseBus->dispatch($input);

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('app/security/account_activate.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
