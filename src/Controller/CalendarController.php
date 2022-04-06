<?php

namespace App\Controller;

use App\Repository\GroupActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends AbstractController
{
    /**
     * @return Response
     */
    public function indexAction(GroupActivityRepository $groupActivityRepository): Response
    {
        $events = $groupActivityRepository->findAll();

        return $this->render('calendar/index.html.twig', [
            'events' => $events,
        ]);
    }

    public function registerAction()
    {
        //todo add registration functionality for event (after login? + mail notification about registration)
    }
}
