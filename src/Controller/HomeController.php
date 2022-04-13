<?php

namespace App\Controller;

use App\Repository\GroupActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private GroupActivityRepository $groupActivityRepository;

    public function __construct(GroupActivityRepository $groupActivityRepository)
    {
        $this->groupActivityRepository = $groupActivityRepository;
    }

    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $closestGroupActivity = $this->groupActivityRepository->findClosestUpcomingActivity();
        $latestAlbum = 'this will be the link to the latest photo album';

        return $this->render('homepage.html.twig', [
            'closestGroupActivity' => $closestGroupActivity,
            'latestAlbum' => $latestAlbum,
        ]);
    }
}
