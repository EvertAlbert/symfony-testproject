<?php

namespace App\Controller;

use App\Repository\TeamMemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    private TeamMemberRepository $teamMemberRepository;

    public function __construct(TeamMemberRepository $teamMemberRepository)
    {
        $this->teamMemberRepository = $teamMemberRepository;
    }

    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $teamMembers = $this->teamMemberRepository->findAll();
        return $this->render('team/index.html.twig', [
            'teamMembers' => $teamMembers
        ]);
    }
}
