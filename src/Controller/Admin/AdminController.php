<?php

namespace App\Controller\Admin;

use App\Entity\GroupActivity;
use App\Entity\MembershipRequest;
use App\Form\GroupActivityType;
use App\Repository\GroupActivityRepository;
use App\Repository\MembershipRequestRepository;
use App\Service\MembershipApprovalNotifier;
use Carbon\Carbon;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;

class AdminController extends AbstractController
{
    private MembershipRequestRepository $membershipRequestRepository;
    private GroupActivityRepository $groupActivityRepository;

    public function __construct(
        MembershipRequestRepository $membershipRequestRepository,
        GroupActivityRepository $groupActivityRepository,
    ) {
        $this->membershipRequestRepository = $membershipRequestRepository;
        $this->groupActivityRepository = $groupActivityRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function indexAction(Request $request): Response
    {
        $newGroupActivity = (new GroupActivity())
            ->setStartDate(Carbon::now()->toDateTimeImmutable())
            ->setEndDate(null)
        ;

        $groupActivityForm = $this->createForm(GroupActivityType::class, $newGroupActivity);

        $groupActivityForm->handleRequest($request);
        if ($groupActivityForm->isSubmitted() && $groupActivityForm->isValid()) {
            $newGroupActivity = $groupActivityForm->getData();
            $this->groupActivityRepository->add($newGroupActivity);

            $groupActivityForm = $this->createForm(
                GroupActivityType::class,
                (new GroupActivity())
                    ->setStartDate(Carbon::now()->toDateTimeImmutable())
                    ->setEndDate(null)
            );

            /** @var GroupActivity $newGroupActivity */
            $this->addFlash(
                'success',
                sprintf('Event created: %s', $newGroupActivity->getName())
            );
            $this->redirectToRoute('admin');
        }

        return $this->render('admin/index.html.twig', [
            'membershipRequests' => $this->membershipRequestRepository->getPendingRequests(),
            'approvedMembershipRequests' => $this->membershipRequestRepository->getApprovedRequests(),
            'groupActivityForm' => $groupActivityForm->createView(),
            'groupActivities' => $this->groupActivityRepository->getGroupActivityDescending(),
        ]);
    }

    public function approveMembershipRequest(MembershipRequest $membershipRequest, MembershipApprovalNotifier $approvalNotifier): Response
    {
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

    public function denyMembershipRequest(MembershipRequest $membershipRequest): Response
    {
        if (!empty($membershipRequest)) {
            $membershipRequest->setRemovedAt(Carbon::now()->toDateTimeImmutable());
            $membershipRequest->setApprovedAt(null);
            $this->membershipRequestRepository->add($membershipRequest);
        }

        //do denial stuff here
        return $this->redirect($this->generateUrl('admin').'#membership-admin');
    }

    public function removeGroupActivity(GroupActivity $groupActivity): Response
    {
        $this->groupActivityRepository->remove($groupActivity);
        $this->addFlash('warning', sprintf('Remove %s?', $groupActivity->getName()));
        return $this->redirect($this->generateUrl('admin').'#calendar-admin');

    }
}
