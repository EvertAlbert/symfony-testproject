<?php

namespace App\Controller;

use App\Entity\MembershipRequest;
use App\Form\MembershipRequestType;
use App\Repository\MembershipRequestRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JoinController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function indexAction(
        Request $request,
        MembershipRequestRepository $membershipRequestRepository
    ): Response {
        $membershipRequest = (new MembershipRequest())
            ->setCreatedAt(Carbon::now()->toDateTimeImmutable())
            ->setUpdatedAt(Carbon::now()->toDateTimeImmutable())
        ;

        $form = $this->createForm(MembershipRequestType::class, $membershipRequest);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $membershipRequest = $form->getData();
            $membershipRequestRepository->add($membershipRequest);
            $form = $this->createForm(
                MembershipRequestType::class,
                (new MembershipRequest())
            );

            /** @var MembershipRequest $membershipRequest */
            $this->addFlash(
                'success',
                sprintf('Request was sent, we will get back in touch via %s!', $membershipRequest->getEmail())
            );
            $this->redirectToRoute('home'); //todo why does this not redirect?
        }

        return $this->render('join/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}