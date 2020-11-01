<?php

declare(strict_types=1);

namespace App\User\Application\AVisitorWantsToSignup;

use App\User\Domain\UseCase\AVisitorWantsToSignup;
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
     * @Route("/signup", methods={"GET", "POST"}, name="signup")
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(Form::class, new FormDto());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FormDto $formData */
            $formData = $form->getData();

            $input = new AVisitorWantsToSignup\Input($formData->firstname, $formData->lastname, $formData->email);
            $this->useCaseBus->dispatch($input);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('app/user_signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
