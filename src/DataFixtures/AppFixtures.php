<?php

namespace App\DataFixtures;

use App\Entity\GroupActivity;
use App\Repository\GroupActivityRepository;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private GroupActivityRepository $groupActivityRepository;

    public function __construct(GroupActivityRepository $groupActivityRepository)
    {
        $this->groupActivityRepository = $groupActivityRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->runGroupActivityFixtures();

        $manager->flush();
    }

    public function runGroupActivityFixtures()
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
}
