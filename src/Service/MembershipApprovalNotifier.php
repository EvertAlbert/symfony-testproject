<?php

namespace App\Service;

use App\Entity\GroupActivity;
use App\Entity\MembershipRequest;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MembershipApprovalNotifier
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendApprovalNotification(Address $user, MembershipRequest $membershipRequest):void
    {
        $email = (new TemplatedEmail())
            ->to($user)
            ->subject(sprintf('Request for Praetoriaa Nausicaa approved!'))
            ->htmlTemplate('email/membership/approved.html.twig')
            ->context([
                'membershipRequest' => $membershipRequest
            ]);

        $this->mailer->send($email);
    }
}