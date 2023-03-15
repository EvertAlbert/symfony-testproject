<?php

namespace App\Factory;

use App\Entity\GroupActivity;
use Carbon\Carbon;

class GroupActivityFactory
{
    public function createGroupActivity(string $activityName): GroupActivity
    {
        return (new GroupActivity())
            ->setName($activityName)
            ->setStartDate(Carbon::now()->toDateTimeImmutable());
    }
}