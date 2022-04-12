<?php

namespace App\Service;

use App\Entity\GroupActivity;
use App\Entity\MembershipRequest;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MembershipRequestNotifier
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendJoinRequestNotification(Address $user, MembershipRequest $membershipRequest):void
    {
        $email = (new TemplatedEmail())
            ->to($user)
            ->subject(sprintf('%s %s would like to join Praetoria Nausicaa',
                $membershipRequest->getFirstName(),
                $membershipRequest->getLastName()
            ))
            ->htmlTemplate('email/membership/request_notification.html.twig')
            ->context([
                'membershipRequest' => $membershipRequest
            ]);

        $this->mailer->send($email);
    }
}