<?php

namespace App\Tests\Appbundle\Entity;

use App\Entity\MembershipRequest;
use PHPUnit\Framework\TestCase;

class MembershipRequestTest extends TestCase
{
    public function testSettingFirstName()
    {
        $membershipRequest = new MembershipRequest();
        $this->assertSame(null, $membershipRequest->getFirstName());

        $membershipRequest->setFirstName('test');
        $this->assertSame('test', $membershipRequest->getFirstName());
    }
}