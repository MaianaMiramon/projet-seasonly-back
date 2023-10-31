<?php

namespace App\Controller\Api;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/api/recipe", name="app_api_recipe_")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="list", methods="GET")
     */
    public function list(RecipeRepository $recipeRepository): JsonResponse
    {
        // Préparation des données
        $allRecipes = $recipeRepository->findAll();

        // dump($allRecipes);

        // Envoie des données
        return $this->json([
            'Recettes' => $allRecipes,
        ]);
    }

    /**
     * @Route("/{id}", name="read", methods="GET", requirements={"id"="\d+"})
     */
    public function read($id, RecipeRepository $recipeRepository): JsonResponse
    {
        // Récupération des données d'une recette selon son id
        $recipe = $recipeRepository->find($id);

        // Si aucune recette ne corresponds à l'id demandé retourner un message d'erreur
        if ($recipe === null)
        {
            $errorMessage = [
                'message' => "Recette introuvable !",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        // Sinon envoie des données
        return $this->json([
            'recette' => $recipe,
        ]);
        
    }

    /**
     * @Route("/", name="create", methods="POST")
     */
    public function create(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // Récupération des données au format Json
        $json = $request->getContent();

        // Deserialisation des données Json pour obtenir un objet
        $recipe = $serializer->deserialize($json, Recipe::class, 'json');

        // persist() prépare l'entité pour la création
        $em->persist($recipe);
        // flush() envoie les données en BDD
        $em->flush();

        // on renvoit une réponse
        return $this->json($recipe);

    }

    /**
     * @Route("/{id}", name="update", methods="PUT", requirements={"id"="\d+"})
     */
    public function update($id, EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // Récupération de la bonne recette, à l'aide du EntityManager
        $recipe = $em->find(Recipe::class, $id);

        // Si aucune recette ne corresponds à l'id demandé retourner un message d'erreur
        if ($recipe === null)
        {
            $errorMessage = [
                'message' => "Recette introuvable",
            ];
            return new JsonResponse($errorMessage);
        }

        // Récupération des données au format json
        $json = $request->getContent();

        // Deserialisation des données Json pour obtenir un objet
        $serializer->deserialize($json, Recipe::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $recipe]);

        // flush() envoie les données en BDD
        $em->flush();

        // on renvoit une réponse
        return $this->json($recipe, Response::HTTP_OK, [], ["groups" => 'recipes_update']);
    }

    /**
     * @Route("/{id}", name="delete", methods="DELETE")
     */
    public function delete($id, EntityManagerInterface $em): JsonResponse
    {
        // Récupération de la recette en base de donnée
        $recipe = $em->find(Recipe::class, $id);

        if ($recipe === null)
        {
            $errorMessage = [
                'message' => "Recette introuvable",
            ];
            return new JsonResponse($errorMessage);
        }

        // $em->remove($monEntite) permet de notifier à Doctrine que
        // l'on souhaite supprimer l'objet de la base de donnée
        $em->remove($recipe);

        // flush() execute les requêtes
        $em->flush();

        return $this->json("Done");
    }
}