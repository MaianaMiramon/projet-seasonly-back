<?php

namespace App\Controller\Back;

use App\Repository\VegetableRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back", name="app_back_")
 */
class VegetableController extends AbstractController
{
    /**
     * @Route("/vegetable", name="list", methods="GET")
     */
    public function list(VegetableRepository $vegetableRepository): Response
    {
        // Préparation des données
        $vegetablesList = $vegetableRepository->findAll();

        // On retourne les données des vegetables au format Json
        return $this->render('back/vegetable/list.html.twig', [
            'vegetables' => $vegetablesList,
        ]);
    }

    /**
     * @Route("/vegetable/{id}", name="show", methods="GET", requirements={"id"="\d+"}) 
     */
    public function show($id, VegetableRepository $vegetableRepository): Response
    {
        // préparation des données
        $vegetable = $vegetableRepository->find($id);

        // On retourne les données du vegetable au format Json
        return $this->render('back/vegetable/show.html.twig', [
            'vegetable' => $vegetable,
        ]);
    }
}