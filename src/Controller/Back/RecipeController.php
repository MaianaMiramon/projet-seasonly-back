<?php

namespace App\Controller\Back;

use App\Entity\Recipe;
use App\Form\Back\RecipeType;
use App\Repository\RecipeRepository;
use App\Repository\ContentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/recipe", name="app_back_recipe_")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(RecipeRepository $recipeRepository, ContentRepository $contentRepository): Response
    {
        // Préparation des données
        $recipesList = $recipeRepository->findAll();

        // On retourne les données des recipes
        return $this->render('back/recipe/index.html.twig', [
            'recipes' => $recipesList,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods="GET", requirements={"id"="\d+"}) 
     */
    public function show($id, RecipeRepository $recipeRepository): Response
    {
        // préparation des données
        $recipe = $recipeRepository->find($id);
        // Récupération des table associé aux recettes
        $content = $recipe->getContents();
        $meal = $recipe->getMeal();

        // On retourne les données de recipes
        return $this->render('back/recipe/show.html.twig', [
            'recipe' => $recipe,
            'contents' => $content,
            'meal' => $meal, 
        ]);
    }

    /**
     * @Route("/{id}/update", name="update", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function update(Request $request, Recipe $recipe, RecipeRepository $recipeRepository): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeRepository->add($recipe, true);

            return $this->redirectToRoute('app_back_recipe_show', ['id' => $recipe->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/recipe/update.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, RecipeRepository $recipeRepository): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeRepository->add($recipe, true);

            return $this->redirectToRoute('app_back_content_create', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/recipe/create.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods="POST", requirements={"id"="\d+"}) 
     */
    public function delete(Request $request, Recipe $recipe, RecipeRepository $recipeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->request->get('_token'))) {
            $recipeRepository->remove($recipe, true);
            $this->addFlash('success', 'Recette supprimé');
        }

        return $this->redirectToRoute('app_back_recipe_index', [], Response::HTTP_SEE_OTHER);
    }
}