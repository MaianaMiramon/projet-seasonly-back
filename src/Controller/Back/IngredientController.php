<?php

namespace App\Controller\Back;

use App\Entity\Ingredient;
use App\Form\Back\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ingredient", name="app_back_ingredient_")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(IngredientRepository $ingredientRepository): Response
    {
        return $this->render('back/ingredient/index.html.twig', [
            'ingredients' => $ingredientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, IngredientRepository $ingredientRepository): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientRepository->add($ingredient, true);

            return $this->redirectToRoute('app_back_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/ingredient/create.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Ingredient $ingredient): Response
    {
        return $this->render('back/ingredient/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * @Route("/{id}/update", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, Ingredient $ingredient, IngredientRepository $ingredientRepository): Response
    {

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientRepository->add($ingredient, true);

            return $this->redirectToRoute('app_back_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/ingredient/update.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Ingredient $ingredient, IngredientRepository $ingredientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $ingredientRepository->remove($ingredient, true);
        }

        return $this->redirectToRoute('app_back_ingredient_index', [], Response::HTTP_SEE_OTHER);
    }
}