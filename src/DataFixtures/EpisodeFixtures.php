<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Service\Slugify;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        $slugify = new Slugify();

        for ($i=0; $i<6; $i++) {
            for ($j = 0; $j <= 10; $j++) {
                $episode = new Episode();
                $episode->setTitle($faker->words(3, true));
                $episode->setNumber($j);
                $episode->setSynopsis($faker->text);
                $slug = $slugify->generate($episode->getTitle());
                $episode->setSlug($slug);
                $episode->setSeason($this->getReference('season_' . $i));

                $manager->persist($episode);
            }
        }
        $manager->flush();


    }
}
