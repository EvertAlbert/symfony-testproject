<?php

namespace App\Controller\Admin;

use App\Entity\GroupActivity;
use App\Repository\GroupActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarAdminController extends AbstractController
{
    private GroupActivityRepository $groupActivityRepository;

    public function __construct(
        GroupActivityRepository $groupActivityRepository,
    ) {
        $this->groupActivityRepository = $groupActivityRepository;
    }

    /**
     * @param GroupActivity $groupActivity
     * @param Request $request
     * @return Response
     */
    public function indexAction(GroupActivity $groupActivity, Request $request): Response
    {
        return $this->render('admin/calendar/remove.html.twig', [
            'groupActivity' => $groupActivity,
        ]);
    }

    public function removeGroupActivity(GroupActivity $groupActivity): Response
    {
        $this->groupActivityRepository->remove($groupActivity);
        return $this->redirect($this->generateUrl('admin').'#calendar-admin');

    }
}
