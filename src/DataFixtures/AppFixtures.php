<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Meal;
use App\Entity\Ingredient;
use App\Entity\Measure;
use App\Entity\Content;
use App\Entity\Vegetable;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void 
    {       



    }
}