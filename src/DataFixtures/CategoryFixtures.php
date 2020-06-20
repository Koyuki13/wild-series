<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
        'Horreur',
    ];

    public function load(ObjectManager $manager)
    {
      foreach (self::CATEGORIES as $key => $categoryName) {
          $category = new Category(); //instancier une nouvelle category a chaque tour de boucle
          $category->setName($categoryName); //lui attribuer via setName() la catégorie en cours

          $manager->persist($category);
          $this->addReference('categorie_' . $key, $category);
          //$key (issue du foreach) permet d'obtenir un identifiant unique pour chaque catégorie, sous la forme 'categorie_0', 'categorie_1', etc., ce qui est plus fiable que les noms qui peuvent contenir des espaces et caractères spéciaux.
      }

      $manager->flush();
    }

}
