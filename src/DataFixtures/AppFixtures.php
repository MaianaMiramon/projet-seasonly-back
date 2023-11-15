<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use App\Entity\Genre;
use App\Entity\Month;
use App\Entity\Recipe;
use App\Entity\Member;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Content;
use App\Entity\Measure;
use App\Entity\Botanical;
use App\Entity\Vegetable;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture 
{
    private $passwordHasher;
    // injecter une dépendance
    public function __construct(UserPasswordHasherInterface $passwordHasherInterface)
    {
        $this->passwordHasher = $passwordHasherInterface;
    }

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

        // Création des Measures
        $measureList = $this->getMeasure();

        foreach ($measureList as $currentMeasureName) {
            // Création de l'objet Measure
            $currentMeasure = new Measure();
            $currentMeasure->setType($currentMeasureName['type']);
            $currentMeasure->setCreatedAt(new DateTimeImmutable($currentMeasureName['created_at']));

            $manager->persist($currentMeasure);
        }
        
        // Création des genres
        $genreList = $this->getGenre();
        
        foreach ($genreList as $currentGenreName) {
            // création de l'objet Genre
            $currentGenre = new Genre();
            $currentGenre->setName($currentGenreName['name']);
            $currentGenre->setCreatedAt(new DateTimeImmutable($currentGenreName['created_at']));
            
            $manager->persist($currentGenre);
            
        }
        
        // Création des botanicals
        $botanicalList = $this->getBotanical();
        // $measureObjectList = [];
        
        foreach ($botanicalList as $currentBotanicalName) {
            // Création de l'objet Botanical
            $currentBotanical = new Botanical();
            $currentBotanical->setName($currentBotanicalName['name']);
            $currentBotanical->setCreatedAt(new DateTimeImmutable($currentBotanicalName['created_at']));
            
            $manager->persist($currentBotanical);
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

        // Creation des Month
        $monthList = $this->getMonths();
        foreach ($monthList as $currentMonthName) {
        // création de l'objet Month
        $currentMonth = new Month();
        $currentMonth->setName($currentMonthName['name']);
        $currentMonth->setCreatedAt(new DateTimeImmutable($currentMonthName['created_at']));
        
        $manager->persist($currentMonth);
    }
        
        
        $manager->flush();
        
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
            
            // Association avec les meal
            $MealRepository = $manager->getRepository(Meal::class);
            $mealList = $MealRepository->findAll();
            foreach ($mealList as $meal)
            {
                $currentMealName = $meal->getName();
                if ($currentMealName === $currentRecipe['meal'])
                {
                    $recipeObject->setMeal($meal);
                }
            }
            
            $manager->persist($recipeObject);
            
        }
        
        // Création des vegetables
        $vegetableList = $this->getVegetables();
        foreach($vegetableList as $currentVegetable) {
            $vegetableObject = new Vegetable();
            $vegetableObject->setTitle($currentVegetable['title']);
            $vegetableObject->setImage($currentVegetable['image']);
            $vegetableObject->setDescription($currentVegetable['description']);
            $vegetableObject->setBenefits($currentVegetable['benefits']);
            $vegetableObject->setLocal($currentVegetable['local']);
            $vegetableObject->setConservation($currentVegetable['conservation']);
            $vegetableObject->setCreatedAt(new DateTimeImmutable($currentVegetable['created_at']));
            
            // Association avec les genres
            $genreRepository = $manager->getRepository(Genre::class);
            $genreList = $genreRepository->findAll();
            foreach ($genreList as $genre)
            {
                $currentGenreName = $genre->getName();
                if ($currentGenreName === $currentVegetable['genre'])
                {
                    $vegetableObject->setGenre($genre);
                }
            }
            
            // Association avec Botanical
            $botanicalRepository = $manager->getRepository(Botanical::class);
            $botanicalList = $botanicalRepository->findAll();
            foreach ($botanicalList as $botanical)
            {
                $currentBotanicalName = $botanical->getName();
                if ($currentBotanicalName === $currentVegetable['botanical'])
                {
                    $vegetableObject->setBotanical($botanical);
                }
            }
            
            // Association avec Ingredient
            $ingredientRepository = $manager->getRepository(Ingredient::class);
            $ingredientList = $ingredientRepository->findAll();
            foreach ($ingredientList as $ingredient)
            {
                $currentIngredientName = $ingredient->getName();
                if ($currentIngredientName === $currentVegetable['ingredient'])
                {
                    $vegetableObject->setIngredient($ingredient);
                }
            }

            // Association avec Month

            // récupération du repository Month
            $monthRepository = $manager->getRepository(Month::class);
            $monthList = $monthRepository->findAll();


            // récupération de la liste des mois du vegetable
            $vegetableMonth = $currentVegetable['month'];
            foreach($vegetableMonth as $month) {
                foreach ($monthList as $monthEntity) {
                    $currentMonthName = $monthEntity->getName();
                    if ($currentMonthName === $month) {
                        $vegetableObject->addMonth($monthEntity);
                    }
                }
            }
            
            $manager->persist($vegetableObject);
        }
        
        $manager->flush();
        
        for ($i = 1; $i <= 11; $i++) {
            // Création Content
            $contentList = $this->getQuantity();
            
            
            $contentRandom = mt_rand(0, count($contentList) -1);
            $currentContentName = $contentList[$contentRandom];
            // Création de l'objet Content
            $currentContent = new Content();
            $currentContent->setQuantity($currentContentName['quantity']);
            
        $measureRepository = $manager->getRepository(Measure::class);
        $measureList = $measureRepository->findAll();
        $measureRandom = mt_rand(0, count($measureList) -1);
        $currentMeasureId = $measureList[$measureRandom];
        $currentContent->setMeasure($currentMeasureId);
        
        $ingredientRepository = $manager->getRepository(Ingredient::class);
        $ingredientList = $ingredientRepository->findAll();
        $ingredientRandom = mt_rand(0, count($ingredientList) -1);
        $currentIngredientId = $ingredientList[$ingredientRandom];
        $currentContent->setIngredient($currentIngredientId);
        
        $recipeRepository = $manager->getRepository(Recipe::class);
        $recipeList = $recipeRepository->findAll();
        $recipeRandom = mt_rand(0, count($recipeList) -1);
        $currentRecipeId = $recipeList[$recipeRandom];
        $currentContent->setRecipe($currentRecipeId);
        
        $manager->persist($currentContent);
        
    }

        // Création des members
        $memberList = $this->getMember();

        foreach ($memberList as $currentUser) {
            $userObject = new User();
            $userObject->setEmail($currentUser['email']);
            $userObject->setNewsletter($currentUser['newsletter']);
            $userObject->setCreatedAt(new DateTimeImmutable($currentUser['created_at']));
            $manager->persist($userObject);
        }
        $manager->flush();

        $userRepository = $manager->getRepository(User::class);
        $userList = $userRepository->findAll();

        foreach($memberList as $currentMember) {
            $memberObject = new Member();
            $memberObject->setPseudo($currentMember['pseudo']);
            $memberObject->setRoles($currentMember['roles']);
            $hashedPassword = $this->passwordHasher->hashPassword($memberObject, $currentMember['password']);
            $memberObject->setPassword($hashedPassword);
            $memberObject->setCreatedAt(new DateTimeImmutable($currentMember['created_at']));
            
            foreach ($userList as $userObject) {
                if ($userObject->getEmail() === $currentMember['email']) {
                    $memberObject->setUser($userObject);
                }
            }    
            
            // Association avec les recettes (favoris)
            $recipeRepository = $manager->getRepository(Recipe::class);
            $recipeList = $recipeRepository->findAll();
            for ($i = 1; $i <= mt_rand(0, 6); $i++) {
            $recipeRandom = mt_rand(0, count($recipeList) -1);
            $currentRecipeId = $recipeList[$recipeRandom];
            $memberObject->addRecipe($currentRecipeId);
        }
            
            $manager->persist($memberObject);

        }

        // Création des users
        $userList = $this->getUser();

        foreach($userList as $currentUser) {
        $userObject = new User();
        $userObject->setEmail($currentUser['email']);
        $userObject->setNewsletter($currentUser['newsletter']);
        $userObject->setCreatedAt(new DateTimeImmutable($currentUser['created_at']));
        
        $manager->persist($userObject);

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
                'name' => 'Légumes racines',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légumes bulbes',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légumes tiges',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légumes graines',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légumes fleurs',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légumes feuilles',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Légumes fruits',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Fruits à noyau',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Fruits à pépins',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Fruits rouges',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Agrumes',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Fruits à coque',
                'created_at' => '2010-03-05',
            ],
            [
                'name' => 'Fruits exotiques',
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
                'quantity' => 1,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 2,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 3,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 4,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 5,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 10,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 20,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 25,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 50,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 100,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 200,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 250,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 300,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 400,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 500,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 600,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 700,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 750,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 800,
                'created_at' => '2010-03-05',
            ],
            [
                'quantity' => 900,
                'created_at' => '2010-03-05',
            ],
        ];
    }

    public function getRecipe() {
        return [
            [
                'title' => 'Pizza',
                'image' => 'https://cdn.pixabay.com/photo/2012/04/01/16/51/pizza-23477_1280.png',
                'description' => 'La pizza est une recette de cuisine traditionnelle de la cuisine italienne, originaire de Naples à base de galette de pâte à pain, garnie principalement d\'huile d\'olive, de sauce tomate, de mozzarella et d\'autres ingrédients et cuite au four.',
                'instruction' => 'Etape 1 : réparer une pâte à pizza ou l\'acheter toute faite, Etape 2 : Étaler la pâte et la recouvrir d\'huile d\'olive, Etape 3 : Couper les tomates en rondelles, la mozzarella en cubes et le jambon en petits carrés. Éplucher l\'oignon et les champignons. Les hacher finement.',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Entrée',
            ],
            [
                'title' => 'Pizza 4 fromages',
                'image' => 'https://cdn.pixabay.com/photo/2012/04/01/16/51/pizza-23477_1280.png',
                'description' => 'Un pizza italienne avec plus de fromages',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 130,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Plat',
            ],
            [
                'title' => 'Salade composé',
                'image' => 'https://cdn.pixabay.com/photo/2014/12/21/23/29/salad-575436_1280.png',
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
                'image' => 'https://cdn.pixabay.com/photo/2012/04/01/16/51/pizza-23477_1280.png',
                'description' => 'Un pizza italienne',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Plat',
            ],
            [
                'title' => 'tarte aux pommes',
                'image' => 'https://cdn.pixabay.com/photo/2018/08/31/14/33/apple-pie-3644790_1280.png',
                'description' => 'Une magnifique tarte aux pommes, pour allié légèreté et gourmandise',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Dessert',
            ],
            [
                'title' => 'Salade de fruit',
                'image' => 'https://cdn.pixabay.com/photo/2014/12/21/23/38/salad-575716_1280.png',
                'description' => 'Un mélange de plusieurs fruits de saison, pour une fin de repas plus légère',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Dessert',
            ],
            [
                'title' => 'tarte au chèvre et au concombre',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'c\'est le moment de se régaler avec une tarte fait maison au chèvre et au au concombre',
                'instruction' => 'Etape 1 : Lorem Ipsum, Etape 3 : Lorem Ipsum, Etape 4 : Lorem Ipsum',
                'duration' => 120,
                'serving' => 4,
                'created_at' => '2010-03-05',
                'meal' => 'Plat',
            ],
            [
                'title' => 'Salade de concombre, orange et noix',
                'image' => 'https://img.freepik.com/photos-gratuite/tranche-pizza-croustillante-viande-du-fromage_140725-6974.jpg?w=740&t=st=1698738808~exp=1698739408~hmac=e7ba4c2635d8def69b6f68203fc449ba7073560733c506f038ee5f6249dfe067',
                'description' => 'Essayer un mélange de saveur avec cette salade composé de concombre, orange et noix',
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
                'title' => 'tomates cerises',
                'description' => 'La tomate cerise est un type de variété de tomate, cultivée comme cette dernière pour ses fruits - mais de taille réduite - consommés comme légumes. Les tomates cerises sont généralement considérées comme des hybrides entre Solanum pimpinellifolium L. et la tomate cultivée, issue de l\'espèce Solanum lycopersicum.',
                'image' => 'https://cdn.pixabay.com/photo/2017/03/26/09/39/tomato-2175133_1280.png',
                'benefits' => 'Vitamines C',
                'local' => true,
                'conservation' => 'Malgré ce que l\'on croit, , il faut éviter de placer les tomates cerises au frigo. L\'air froid va les empécher de continuer à mûrir.',
                'created_at' => '2010-03-05',
                'month' => ['juillet', 'août', 'septembre'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'tomate',
            ],
            [
                'title' => 'tomates coeur de boeuf',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2017/03/26/09/39/tomato-2175133_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['juillet', 'août', 'septembre'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'tomate',
            ],
            [
                'title' => 'pomme golden',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/05/28/13/22/fruit-356519_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['septembre', 'octobre'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'pomme',
            ],
            [
                'title' => 'pomme gala',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/05/28/13/22/fruit-356519_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['octobre', 'novembre', 'décembre'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'pomme',
            ],
            [
                'title' => 'pomme',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/05/28/13/22/fruit-356519_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['juillet', 'août'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'pomme',
            ],
            [
                'title' => 'citron vert',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2013/07/12/19/16/lemon-154449_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['juin', 'juillet', 'août'],
                'botanical' => 'Agrumes',
                'genre' => 'Fruit',
                'ingredient' => 'citron',
            ],
            [
                'title' => 'citron jaune',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2013/07/12/19/16/lemon-154449_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['juillet', 'août', 'septembre'],
                'botanical' => 'Agrumes',
                'genre' => 'Fruit',
                'ingredient' => 'citron',
            ],
            [
                'title' => 'pomme',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/05/28/13/22/fruit-356519_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['janvier', 'février', 'mars'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'pomme',
            ],
            [
                'title' => 'salade romaine',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/03/24/17/08/lettuce-295158_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['avril', 'mai', 'juin', 'juillet'],
                'botanical' => 'Légumes feuilles',
                'genre' => 'Légume',
                'ingredient' => 'salade',
            ],
            [
                'title' => 'salade batavia',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/03/24/17/08/lettuce-295158_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['mars', 'avril', 'mai'],
                'botanical' => 'Légumes feuilles',
                'genre' => 'Légume',
                'ingredient' => 'salade',
            ],
            [
                'title' => 'mini concombre',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2022/01/14/00/30/cucumber-6936214_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['mai', 'juin'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'concombre',
            ],
            [
                'title' => 'concombre blanc',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2022/01/14/00/30/cucumber-6936214_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['avril', 'mai', 'juin', 'juillet'],
                'botanical' => 'Fruits à pépins',
                'genre' => 'Fruit',
                'ingredient' => 'concombre',
            ],
            [
                'title' => 'aubergine de barbentane',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2020/03/28/17/01/eggplant-4977808_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['juin', 'juillet', 'août'],
                'botanical' => 'Légumes fruits',
                'genre' => 'Légume',
                'ingredient' => 'aubergine',
            ],
            [
                'title' => 'aubergine black beauty',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2020/03/28/17/01/eggplant-4977808_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['juin', 'jillet', 'août', 'septembre'],
                'botanical' => 'Légumes fruits',
                'genre' => 'Légume',
                'ingredient' => 'aubergine',
            ],
            [
                'title' => 'fraise gariguette',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2012/04/18/12/54/strawberry-36949_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['avril', 'mai', 'juin'],
                'botanical' => 'Fruits rouges',
                'genre' => 'Fruit',
                'ingredient' => 'fraise',
            ],
            [
                'title' => 'fraise reine des vallées',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2012/04/18/12/54/strawberry-36949_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['avril', 'mai', 'juin'],
                'botanical' => 'Fruits rouges',
                'genre' => 'Fruit',
                'ingredient' => 'fraise',
            ],
            [
                'title' => 'banane cavendish',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/12/21/23/39/bananas-575773_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['octobre', 'novembre', 'décembre'],
                'botanical' => 'Fruits exotiques',
                'genre' => 'Fruit',
                'ingredient' => 'banane',
            ],
            [
                'title' => 'banane plantain',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'image' => 'https://cdn.pixabay.com/photo/2014/12/21/23/39/bananas-575773_1280.png',
                'benefits' => 'Lorem ipsum dolor sit amet',
                'local' => true,
                'conservation' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2010-03-05',
                'month' => ['septembre', 'octobre', 'novembre', 'décembre', 'janvier'],
                'botanical' => 'Fruits exotiques',
                'genre' => 'Fruit',
                'ingredient' => 'banane',
          ],
        ];
    }
    
    public function getUser() {
        return [
            [
                'email' => 'john@gmail.com',
                'newsletter' => true,
                'created_at' => '2017-03-05',
            ],
            [
                'email' => 'coucou@hotmail.fr',
                'newsletter' => false,
                'created_at' => '2017-03-05',
            ],
            [
                'email' => 'sylvie@laposte.net',
                'newsletter' => true,
                'created_at' => '2017-03-05',
            ],
            [
                'email' => 'marie@yahoo.fr',
                'newsletter' => true,
                'created_at' => '2017-03-05',
            ],
            [
                'email' => 'pierre@gmail.com',
                'newsletter' => false,
                'created_at' => '2017-03-05',
            ],
            [
                'email' => 'nicolas@gmail.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'baptiste@hotmail.fr',
                'newsletter' => false,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'clément@gmail.com',
                'newsletter' => false,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'megane@yahoo.fr',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'eloise@gmail.com',
                'newsletter' => false,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'jimmy@butler.com',
                'newsletter' => false,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'victor@hotmail.fr',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'cécile@gmail.com',
                'newsletter' => false,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'kylian@laposte.net',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'email' => 'sarah@hotmail.fr',
                'newsletter' => false,
                'created_at' => '2023-10-12',
            ],
          ];
    }

    public function getMember() {
        return [
            [
                'pseudo' => 'gilles',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'gilles',
                'email' => 'gilles@gilles.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'david',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'david',
                'email' => 'david@david.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'cyprien',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'cyprien',
                'email' => 'cyprien@cyprien.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'maïana',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'maïana',
                'email' => 'maïana@maïana.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'antoine',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'antoine',
                'email' => 'antoine@antoine.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'patrice',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'patrice',
                'email' => 'patrice@patrice.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'caroline',
                'roles' => [''],
                'password' => 'caroline',
                'email' => 'caroline@caroline.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'romain',
                'roles' => [''],
                'password' => 'romain',
                'email' => 'romain@bleh.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'salomé',
                'roles' => [''],
                'password' => 'salomé',
                'email' => 'salomé@salomé.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'lucas',
                'roles' => [''],
                'password' => 'lucas',
                'email' => 'lucas@debleh.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'mélina',
                'roles' => [''],
                'password' => 'mélina',
                'email' => 'mélina@mélina.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'admin',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'admin',
                'email' => 'admin@admin.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'member',
                'roles' => [''],
                'password' => 'member',
                'email' => 'member@member.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'squeezie',
                'roles' => [''],
                'password' => 'squeezie',
                'email' => 'squeezie@squeezie.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
            [
                'pseudo' => 'kameto',
                'roles' => [''],
                'password' => 'kameto',
                'email' => 'kameto@kameto.com',
                'newsletter' => true,
                'created_at' => '2023-10-12',
            ],
        ];
    }
}