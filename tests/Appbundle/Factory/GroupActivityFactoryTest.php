<?php

namespace App\Tests\Appbundle\Factory;

use App\Entity\GroupActivity;
use App\Factory\GroupActivityFactory;
use PHPUnit\Framework\TestCase;

class GroupActivityFactoryTest extends TestCase
{
    private GroupActivityFactory $factory;

    public function setUp(): void
    {
        $this->factory = new GroupActivityFactory();
    }

    public function testItCreatesAGroupEvent(): void
    {
        $groupActivity = $this->factory->createGroupActivity('testname');

        $this->assertInstanceOf(GroupActivity::class, $groupActivity);
        $this->assertSame('testname', $groupActivity->getName());
    }
}