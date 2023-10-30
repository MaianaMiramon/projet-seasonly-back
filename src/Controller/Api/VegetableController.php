<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VegetableController extends AbstractController
{
    /**
     * @Route("/vegetable", name="app_vegetable")
     */
    public function index(): Response
    {
        return $this->render('vegetable/index.html.twig', [
            'controller_name' => 'VegetableController',
        ]);
    }
}
