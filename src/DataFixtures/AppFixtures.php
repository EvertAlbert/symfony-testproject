<?php

namespace App\DataFixtures;

use App\Entity\GroupActivity;
use App\Entity\TeamMember;
use App\Entity\User;
use App\Repository\GroupActivityRepository;
use App\Repository\TeamMemberRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private GroupActivityRepository $groupActivityRepository;
    private TeamMemberRepository $teamMemberRepository;
    private UserRepository $userRepository;

    public function __construct(
        GroupActivityRepository $groupActivityRepository,
        TeamMemberRepository $teamMemberRepository,
        UserRepository $userRepository,
    ) {
        $this->groupActivityRepository = $groupActivityRepository;
        $this->teamMemberRepository = $teamMemberRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->runGroupActivityFixtures();
        $this->runTeamMemberFixtures();
        $this->runUserFixtures();

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

    public function runUserFixtures(): void
    {
        $user = (new User())
            ->setFirstName('Evert')
            ->setLastName('Albert')
            ->setEmail('evert.albert@hotmail.be')
            ->setRoles([])
            ->setPassword('test')
        ;
        $this->userRepository->add($user);


        for ($i = 0; $i < 5; $i++) {
            $newUser = (new User())
                ->setEmail(sprintf('user%s@test.com', $i))
                ->setRoles([])
                ->setPassword('test')
            ;
            $this->userRepository->add($newUser);
        }
    }
}
