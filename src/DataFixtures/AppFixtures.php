<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Meal;
use App\Entity\Ingredient;
use App\Entity\Measure;
use App\Entity\Content;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void 
    {       
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
  
            $manager->persist($recipeObject);
        }

        // Création des Meal
        $mealList = $this->getMeal();
        // $mealObjectList = [];
        foreach ($mealList as $currentMealName) {
        // création de l'objet Meal
        $currentMeal = new Meal();
        $currentMeal->setName($currentMealName['name']);
        $currentMeal->setCreatedAt(new DateTimeImmutable($currentRecipe['created_at']));

        $manager->persist($currentMeal);
        // $mealObjectList[$currentMealName] = $currentMeal;
        }

        // Création des Measures
        $measureList = $this->getMeasure();
        // $measureObjectList = [];

        foreach ($measureList as $currentMeasureName) {
            // Création de l'objet Measure
            $currentMeasure = new Measure();
            $currentMeasure->setType($currentMeasureName['type']);
            $currentMeasure->setCreatedAt(new DateTimeImmutable($currentRecipe['created_at']));

            $manager->persist($currentMeasure);
            // $measureObjectList[$currentMeasureName] = $currentMeasure;
        }
        
        // Creation des Ingredients
        $ingredientList = $this->getIngredient();
        // $ingredientObjectList = [];
        foreach ($ingredientList as $currentIngredientName) {
        // création de l'objet Ingredient
        $currentIngredient = new Ingredient();
        $currentIngredient->setName($currentIngredientName['name']);
        $currentIngredient->setCreatedAt(new DateTimeImmutable($currentRecipe['created_at']));

        $manager->persist($currentIngredient);
        // $ingredientObjectList[$currentIngredientName] = $currentIngredient;
        }

        $manager->flush();
        
        // Création des Content
        $quantityList = $this->getQuantity();
        $quantityObjectList = [];

        foreach ($quantityList as $currentQuantityMeasure) {
            // Création de l'objet Content

        }

        // TODO Création des Members
        // TODO Création des Users
        
        
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
            ],
            [
                'title' => 'Pizza 4 fromages',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un pizza italienne avec plus de fromages',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 130,
                'serving' => 4,
                'created_at' => '2010-03-05',
            ],
            [
                'title' => 'Salade composé',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un salade avec plein d\'aliments',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
            ],
            [
                'title' => 'Ratatouille',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un mélange de légumes',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 230,
                'serving' => 6,
                'created_at' => '2010-03-05',
            ],
            [
                'title' => 'Pizza',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Un pizza italienne',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
            ],
        ];
    }
}