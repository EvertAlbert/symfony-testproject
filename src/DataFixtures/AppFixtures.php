<?php

namespace App\DataFixtures;

use App\Entity\GroupActivity;
use App\Entity\TeamMember;
use App\Repository\GroupActivityRepository;
use App\Repository\TeamMemberRepository;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private GroupActivityRepository $groupActivityRepository;
    private TeamMemberRepository $teamMemberRepository;

    public function __construct(
        GroupActivityRepository $groupActivityRepository,
        TeamMemberRepository $teamMemberRepository,
    ) {
        $this->groupActivityRepository = $groupActivityRepository;
        $this->teamMemberRepository = $teamMemberRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->runGroupActivityFixtures();
        $this->runTeamMemberFixtures();

        $manager->flush();
    }

    public function runGroupActivityFixtures(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $event = (new GroupActivity())
                ->setName(sprintf('testevent %s', $i))
                ->setStartDate(Carbon::tomorrow())
                ->setEndDate(Carbon::tomorrow())
                ->setDescription(
                    sprintf('This is a long description of some event. This is eventnumber %s. Depending on whether
                    this description is entered it wil be displayed or not.', $i)
                )
            ;

            try {
                $this->groupActivityRepository->add($event);
            } catch (\Exception $e) {
                dump($e);
            }
        }
    }

    public function runTeamMemberFixtures(): void
    {
        $members = [];
        $members[] = (new TeamMember())
            ->setFirstName('Maxim')
            ->setLastName('D.')
            ->setCallName('Maximus')
            ->setPhoto('/build/images/team/maxim.jpg')
            ->setWeaponOfChoice('FN P90')
        ;

        $members[] = (new TeamMember())
            ->setFirstName('Ward')
            ->setLastName('D.')
            ->setPhoto('/build/images/team/ward.jpg')
            ->setWeaponOfChoice('FN SCAR')
        ;

        $members[] = (new TeamMember())
            ->setFirstName('Evert')
            ->setLastName('A.')
            ->setPhoto('/build/images/team/evert.jpg')
            ->setWeaponOfChoice('Kriss Vector')
            ->setCallName('Spectral')
        ;

        foreach ($members as $member) {
            $this->teamMemberRepository->add($member);
        }
    }
}
