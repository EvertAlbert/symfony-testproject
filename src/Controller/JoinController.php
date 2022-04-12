<?php

namespace App\Controller;

use App\Entity\MembershipRequest;
use App\Form\MembershipRequestType;
use App\Repository\MembershipRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JoinController extends AbstractController
{
    /**
     * @return Response
     */
    public function indexAction(
        Request $request,
        MembershipRequestRepository $membershipRequestRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $membershipRequest = new MembershipRequest();

        $form = $this->createForm(MembershipRequestType::class, $membershipRequest);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $membershipRequest = $form->getData();
            $form = $this->createForm(MembershipRequestType::class, new MembershipRequest());

            $entityManager->persist($membershipRequest);
            $entityManager->flush();

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