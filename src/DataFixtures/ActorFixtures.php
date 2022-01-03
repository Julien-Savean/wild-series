<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public const ACTORS = [
        'Al Pacino',
        'Robert De Niro',
        'Clint Eastwood',
        'Jennifer Lawrence',
        'Charlize Theron',
        'Rachel Weisz',
        'Eva Green',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName){
            $actor = new Actor();
            $actor->setName($actorName);
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }

        $manager->flush();
    }
}