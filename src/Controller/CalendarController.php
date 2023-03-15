<?php

namespace App\Controller;

use App\Repository\GroupActivityRepository;
use App\Service\ConfirmationEmailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;

class CalendarController extends AbstractController
{
    private GroupActivityRepository $groupActivityRepository;

    public function __construct(GroupActivityRepository $groupActivityRepository)
    {
        $this->groupActivityRepository = $groupActivityRepository;
    }

    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $groupActivities = $this->groupActivityRepository->getGroupActivityDescending();

        return $this->render('calendar/index.html.twig', [
            'groupActivities' => $groupActivities,
        ]);
    }

    /**
     * @param int $groupActivityId
     * @param ConfirmationEmailSender $confirmationEmailSender
     * @return RedirectResponse
     */
    public function registerAction(int $groupActivityId, ConfirmationEmailSender $confirmationEmailSender): RedirectResponse
    {
        //todo implement users on the website / implement a registration form with name & email
        $user = new Address('evert.albert@hotmail.be', 'Evert');

        $groupActivity = $this->groupActivityRepository->find($groupActivityId);
        if (!$groupActivity) {
            $this->addFlash(
                'warning',
                'Event not found, please contact us about this issue.'
            );
            return $this->redirectToRoute('calendar');
        }

        $confirmationEmailSender->sendGroupActivityRegistrationConfirmation($user, $groupActivity);
        $this->addFlash(
            'success',
            sprintf('Registered for %s, please check your email.', $groupActivity->getName())
        );

        return $this->redirectToRoute('calendar');
    }
}
