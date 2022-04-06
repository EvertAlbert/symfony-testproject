<?php

namespace App\Controller;

use App\Entity\GroupActivity;
use App\Repository\GroupActivityRepository;
use Carbon\Carbon;
use Couchbase\Group;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends AbstractController
{
    /**
     * @return Response
     */
    public function indexAction(GroupActivityRepository $groupActivityRepository): Response
    {
//        $event1 = new GroupActivity();
//        $event1
//            ->setName('testevent 1')
//            ->setStartDate(Carbon::now());
//
//        $event2 = new GroupActivity();
//        $event2
//            ->setName('event 2')
//            ->setStartDate(Carbon::now())
//            ->setEndDate(Carbon::now())
//            ->setDescription('This is the description of the second event')
//        ;
//
//        $groupActivityRepository->add($event1);
//        $groupActivityRepository->add($event2);

        $events = $groupActivityRepository->findAll();

        return $this->render('calendar/index.html.twig', [
            'events' => $events,
        ]);
    }
}
