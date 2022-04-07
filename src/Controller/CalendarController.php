<?php

namespace App\Controller;

use App\Entity\GroupActivity;
use App\Repository\GroupActivityRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class CalendarController extends AbstractController
{
    private GroupActivityRepository $groupActivityRepository;
    private MailerInterface $mailer;

    public function __construct(
        GroupActivityRepository $groupActivityRepository,
        MailerInterface $mailer,
    ) {
        $this->groupActivityRepository = $groupActivityRepository;
        $this->mailer = $mailer;
    }

    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $events = $this->groupActivityRepository->findAll();

        return $this->render('calendar/index.html.twig', [
            'events' => $events,
        ]);
    }

    public function registerAction(int $eventId): RedirectResponse
    {
        //todo implement users on the website / implement a registration form with name & email
        $user = new Address('evert.albert@hotmail.be', 'Evert');

        $groupActivity = $this->groupActivityRepository->find($eventId);
        if (!$groupActivity) {
            $this->addFlash(
                'warning',
                'Event not found, please contact us about this issue.'
            );
            return $this->redirectToRoute('calendar');
        }

        $this->sendEventRegistrationConfirmation($user, $groupActivity);
        $this->addFlash(
            'success',
            sprintf('Registered for %s, please check your email.', $groupActivity->getName())
        );

        return $this->redirectToRoute('calendar');
    }

    private function sendEventRegistrationConfirmation(Address $user, GroupActivity $groupActivity)
    {
        $groupActivityName = $groupActivity->getName();

        $email = (new TemplatedEmail())
            ->to($user)
            ->subject(sprintf('Registration for %s', $groupActivityName))
            ->htmlTemplate('email/event/registration.html.twig')
            ->context([
                'event' => $groupActivity
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            //todo catch this exception
        }
    }
}
