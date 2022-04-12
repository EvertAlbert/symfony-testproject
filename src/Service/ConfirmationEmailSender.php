<?php

namespace App\Service;

use App\Entity\GroupActivity;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ConfirmationEmailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendGroupActivityRegistrationConfirmation(Address $user, GroupActivity $groupActivity):void
    {
        $groupActivityName = $groupActivity->getName();
        $email = (new TemplatedEmail())
            ->to($user)
            ->subject(sprintf('Registration for %s', $groupActivityName))
            ->htmlTemplate('email/event/registration.html.twig')
            ->context([
                'groupActivity' => $groupActivity
            ]);

        $this->mailer->send($email);
    }
}