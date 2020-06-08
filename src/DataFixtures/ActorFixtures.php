<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

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
        $faker  =  Faker\Factory::create('fr_FR');

        $i = 0;
        foreach (self::ACTORS as $actorName => $data) {
            $actor = new Actor(); //instancier une nouvelle category a chaque tour de boucle
            $actor->setName($actorName); //lui attribuer via setName() la catégorie en cours
            foreach ($data as $program){
                $actor->addProgram($this->getReference($program));
            }
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $i++;
        }

        for ($i = 5; $i < 50; $i++) {
            $actor->setName($faker->numberBetween(1, 20))
                ->addProgram($this->getReference($program));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }
}