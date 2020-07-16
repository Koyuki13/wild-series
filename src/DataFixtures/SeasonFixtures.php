<?php


namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');

        for ($i=0; $i<6; $i++) {
            if (!isset($k)) {
                $k = 0;
            }
            for ($j = 1; $j < 6; $j++) {
                $season = new Season();
                $season->setNumber($j);
                $season->setYear($faker->year);
                $season->setDescription($faker->text);
                $season->setProgram($this->getReference('program_' . $i));
                $manager->persist($season);
                $this->addReference('season_' . $k, $season);
                $k ++;

            }
        }
        $manager->flush();
    }

}