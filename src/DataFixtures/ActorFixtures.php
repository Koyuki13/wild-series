<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Service\Slugify;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln' => [
            'program_1',
        ],

        'Victoria Pedretti' => [
            'program_2'
        ],

        'Evan Peters' => [
            'program_3'
        ],

        'Eva Green' => [
            'program_4'
        ],

        'Alicia Clark' => [
            'program_5'
        ],
    ];

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $i = 0;
        $slugify = new Slugify();
        foreach (self::ACTORS as $actorName => $data) {
            $actor = new Actor(); //instancier une nouvelle category a chaque tour de boucle
            $actor->setName($actorName); //lui attribuer via setName() la catégorie en cours
            $slug = $slugify->generate($actor->getName());
            $actor->setSlug($slug);
            foreach ($data as $program){
                $actor->addProgram($this->getReference($program));
            }
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $i++;
        }

        $manager->flush();
    }
}