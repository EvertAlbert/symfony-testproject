<?php

namespace App\EventListener;

use App\Entity\MembershipRequest;
use App\Service\MembershipRequestNotifier;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Mime\Address;

class MembershipRequestListener
{
    private MembershipRequestNotifier $membershipRequestNotifier;

    public function __construct(MembershipRequestNotifier $membershipRequestNotifier)
    {

        $this->membershipRequestNotifier = $membershipRequestNotifier;
    }

    public function postPersist(MembershipRequest $membershipRequest, LifecycleEventArgs $event): void
    {
        $membershipRequestReceiver = new Address('evert.albert@hotmail.be', 'Evert');
        $this->membershipRequestNotifier->sendJoinRequestNotification($membershipRequestReceiver, $membershipRequest);
    }

}