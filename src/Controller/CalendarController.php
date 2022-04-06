<?php

namespace App\Controller;

use App\Repository\GroupActivityRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

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

    public function registerAction(int $eventId): Response
    {
        $events = $this->groupActivityRepository->findAll();
        $event = $this->groupActivityRepository->find($eventId);

        if (!$event) {
            return $this->render('calendar/index.html.twig', [
                'events' => $events,
            ]);
        }

        $eventName = $event->getName();
        $email = (new TemplatedEmail())
            ->to(new Address('evert.albert@hotmail.be', 'Evert'))
            ->subject(sprintf('Registration for %s', $eventName))
            ->htmlTemplate('email/event/registration.html.twig')
            ->context([
                'event' => $event
            ]);

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            dd($e);
        }

        return $this->render('calendar/index.html.twig', [
            'events' => $events,
        ]);
    }
}
