<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Meal;
use App\Entity\Ingredient;
use App\Entity\Measure;
use App\Entity\Content;
use DateTimeImmutable;
use App\Entity\Genre;
use App\Entity\Month;
use App\Entity\Botanical;
use App\Entity\Vegetable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void 
    {       
        // Création des Meal
        $mealList = $this->getMeal();
        foreach ($mealList as $currentMealName) {
        // création de l'objet Meal
        $currentMeal = new Meal();
        $currentMeal->setName($currentMealName['name']);
        $currentMeal->setCreatedAt(new DateTimeImmutable($currentMealName['created_at']));

        $manager->persist($currentMeal);
        }
        
        // Création des recettes
        $recipeList = $this->getRecipe();
        foreach($recipeList as $currentRecipe) {
            $recipeObject = new Recipe();
            $recipeObject->setTitle($currentRecipe['title']);
            $recipeObject->setImage($currentRecipe['image']);
            $recipeObject->setDescription($currentRecipe['description']);
            $recipeObject->setInstruction($currentRecipe['instruction']);
            $recipeObject->setDuration($currentRecipe['duration']);
            $recipeObject->setServing($currentRecipe['serving']);
            $recipeObject->setCreatedAt(new DateTimeImmutable($currentRecipe['created_at']));
            
            // TODO Association avec les meal
            
            
            $manager->persist($recipeObject);
        }
        
        
        // Création des Measures
        $measureList = $this->getMeasure();

        foreach ($measureList as $currentMeasureName) {
            // Création de l'objet Measure
            $currentMeasure = new Measure();
            $currentMeasure->setType($currentMeasureName['type']);
            $currentMeasure->setCreatedAt(new DateTimeImmutable($currentMeasureName['created_at']));

            $manager->persist($currentMeasure);
        }
  
        // Création des vegetables
        $vegetableList = $this->getVegetables();
        foreach($vegetableList as $currentVegetable) {
            $vegetableObject = new Vegetable();
            $vegetableObject->setName($currentVegetable['name']);
            $vegetableObject->setImage($currentVegetable['image']);
            $vegetableObject->setDescription($currentVegetable['description']);
            $vegetableObject->setBenefits($currentVegetable['benefits']);
            $vegetableObject->setLocal($currentVegetable['local']);
            $vegetableObject->setConservation($currentVegetable['conservation']);
            $vegetableObject->setCreatedAt(new DateTimeImmutable($currentVegetable['created_at']));
  
            $manager->persist($vegetableObject);
        }

        // Création des genres
        $genreList = $this->getGenre();

        foreach ($genreList as $currentGenreName) {
        // création de l'objet Genre
        $currentGenre = new Genre();
        $currentGenre->setName($currentGenreName['name']);
        $currentGenre->setCreatedAt(new DateTimeImmutable($currentVegetable['created_at']));

        $manager->persist($currentGenre);

        }

        // Création des botanicals
        $botanicalList = $this->getBotanical();
        // $measureObjectList = [];

        foreach ($botanicalList as $currentBotanicalName) {
            // Création de l'objet Botanical
            $currentBotanical = new Botanical();
            $currentBotanical->setName($currentBotanicalName['name']);
            $currentBotanical->setCreatedAt(new DateTimeImmutable($currentVegetable['created_at']));

            $manager->persist($currentBotanical);
        }
        
        // Creation des Month
        $monthList = $this->getMonths();
        // $ingredientObjectList = [];
        foreach ($monthList as $currentMonthName) {
        // création de l'objet Month
        $currentMonth = new Month();
        $currentMonth->setName($currentMonthName['name']);
        $currentMonth->setCreatedAt(new DateTimeImmutable($currentVegetable['created_at']));

        $manager->persist($currentMonth);
        }

        // Creation des Ingredients
        $ingredientList = $this->getIngredient();

        foreach ($ingredientList as $currentIngredientName) {
        // création de l'objet Ingredient
        $currentIngredient = new Ingredient();
        $currentIngredient->setName($currentIngredientName['name']);
        $currentIngredient->setCreatedAt(new DateTimeImmutable($currentIngredientName['created_at']));

        $manager->persist($currentIngredient);
        }

        $manager->flush();
        
    }

    public function getMeal() {
        return [
            [
                'name' => 'Entrée',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Plat',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Dessert',
                'created_at' => '2010-03-05',
            ],
        ];
    }

    public function getGenre() {
        return [
            [
                'name' => 'Fruit',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légume',
                'created_at' => '2010-03-05',
            ],
        ];
    }

    public function getMeasure() {
        return [
            [
                'type' => 'ml',
                'created_at' => '2010-03-05',
            ],
            [
                'type' => 'cl',
                'created_at' => '2010-03-05',
            ],
            [
                'type' => 'l',
                'created_at' => '2010-03-05',
            ],
            [
                'type' => 'g',
                'created_at' => '2010-03-05',
            ],
            [
                'type' => 'kl',
                'created_at' => '2010-03-05',
            ],
          ];
      }

    public function getBotanical() {
        return [
            [
                'name' => 'Légume racine',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légume bulbe',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légume tige',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légume graine',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légume fleur',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légume feuille',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légume fruit',
                'created_at' => '2010-03-05',
            ],
        ];
    }

    public function getIngredient() {
        return [
            [
                'name' => 'tomate',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'aubergine',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'pomme de terre',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'farine',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'oeuf',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'concombre',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'salade',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'fraise',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'citron',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'banane',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'pomme',
                'created_at' => '2010-03-05',
            ],
        ];
    }

    public function getQuantity() {
        return [
            [
                1,
                'created_at' => '2010-03-05',
            ],
            [
                2,
                'created_at' => '2010-03-05',
            ],
            [
                3,
                'created_at' => '2010-03-05',
            ],
            [
                4,
                'created_at' => '2010-03-05',
            ],
            [
                5,
                'created_at' => '2010-03-05',
            ],
            [
                10,
                'created_at' => '2010-03-05',
            ],
            [
                20,
                'created_at' => '2010-03-05',
            ],
            [
                25,
                'created_at' => '2010-03-05',
            ],
            [
                50,
                'created_at' => '2010-03-05',
            ],
            [
                100,
                'created_at' => '2010-03-05',
            ],
            [
                200,
                'created_at' => '2010-03-05',
            ],
            [
                250,
                'created_at' => '2010-03-05',
            ],
            [
                300,
                'created_at' => '2010-03-05',
            ],
            [
                400,
                'created_at' => '2010-03-05',
            ],
            [
                500,
                'created_at' => '2010-03-05',
            ],
            [
                600,
                'created_at' => '2010-03-05',
            ],
            [
                700,
                'created_at' => '2010-03-05',
            ],
            [
                750,
                'created_at' => '2010-03-05',
            ],
            [
                800,
                'created_at' => '2010-03-05',
            ],
            [
                900,
                'created_at' => '2010-03-05',
            ],
        ];
    }

    public function getRecipe() {
        return [
            [
                'title' => 'Pizza',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un pizza italienne',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Entrée',
            ],
            [
                'title' => 'Pizza 4 fromages',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un pizza italienne avec plus de fromages',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 130,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Plat',
            ],
            [
                'title' => 'Salade composé',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un salade avec plein d\'aliments',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Entrée',
            ],
            [
                'title' => 'Ratatouille',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un mélange de légumes',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 230,
                'serving' => 6,
                'created_at' => '2010-03-05',
                'meal' => 'Plat',
            ],
            [
                'title' => 'Pizza',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un pizza italienne',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Plat',
              ],
          ];
    }
  
    public function getMonths() {
        return [
            [
                'name' => 'janvier',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'février',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'mars',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'avril',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'mai',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'juin',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'juillet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'août',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'septembre',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'octobre',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'novembre',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'décembre',
                'created_at' => '2010-03-05',
            ],
        ];
    }

    public function getVegetables() {
        return [
            [   
                'name' => 'tomates cerises',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'tomates coeur de boeuf',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'pomme golden',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'pomme gala',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'pomme',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'citron vert',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'citron jaune',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'pomme',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'salade romaine',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'salade batavia',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'mini concombre',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'concombre blanc',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'aubergine de barbentane',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'aubergine black beauty',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'fraise gariguette',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'fraise reine des vallées',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'banane cavendish',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'banane plantain',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
          ],
        ];
    }
}