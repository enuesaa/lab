<?php

namespace App\DataFixtures;

use App\Entity\Memo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $memo = new Memo();
        $memo->setTitle('aaa');
        $memo->setDescription('bb');
        $manager->persist($memo);

        $manager->flush();
    }
}
