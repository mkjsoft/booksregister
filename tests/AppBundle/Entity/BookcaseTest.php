<?php

namespace App\Tests\AppBundle\Entity;

use App\Entity\Bookcase;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class BookcaseTest extends TestCase
{
    public function testBookcaseCreate()
    {
        $user = new User();

        $bookcase = new Bookcase();
        $bookcase->setName("Bookcase Name");
        $bookcase->setUser($user);
        $this->assertEquals("Bookcase Name", $bookcase->getName());
    }

}