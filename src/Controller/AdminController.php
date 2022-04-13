<?php

namespace App\Controller;

use App\Repository\MembershipRequestRepository;
use App\Service\MembershipApprovalNotifier;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;

class AdminController extends AbstractController
{
    private MembershipRequestRepository $membershipRequestRepository;

    public function __construct(
        MembershipRequestRepository $membershipRequestRepository
    ) {
        $this->membershipRequestRepository = $membershipRequestRepository;
    }

    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('admin/index.html.twig', [
            'membershipRequests' => $this->membershipRequestRepository->getPendingRequests(),
            'approvedMembershipRequests' => $this->membershipRequestRepository->getApprovedRequests(),
        ]);
    }

    public function approveMembershipRequest(int $id, MembershipApprovalNotifier $approvalNotifier): Response
    {
        $membershipRequest = $this->membershipRequestRepository->find($id);
        if (!empty($membershipRequest)) {
            $membershipRequest->setApprovedAt(Carbon::now()->toDateTimeImmutable());
            $membershipRequest->setRemovedAt(null);
            $this->membershipRequestRepository->add($membershipRequest);

            $receiver = new Address(
                $membershipRequest->getEmail(),
                sprintf(
                    '%s %s',
                    $membershipRequest->getFirstName(),
                    $membershipRequest->getLastName()
                )
            );

            $approvalNotifier->sendApprovalNotification($receiver, $membershipRequest);
        }

        //do approval stuff here
        return $this->redirect($this->generateUrl('admin').'#membership-admin');
    }

    public function denyMembershipRequest(int $id): Response
    {
        $membershipRequest = $this->membershipRequestRepository->find($id);
        if (!empty($membershipRequest)) {
            $membershipRequest->setRemovedAt(Carbon::now()->toDateTimeImmutable());
            $membershipRequest->setApprovedAt(null);
            $this->membershipRequestRepository->add($membershipRequest);
        }

        //do denial stuff here
        return $this->redirect($this->generateUrl('admin').'#membership-admin');
    }
}
