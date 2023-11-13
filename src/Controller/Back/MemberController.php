<?php

namespace App\Controller\Back;

use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/member", name="app_back_member_")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(MemberRepository $memberRepository): Response
    {
        // Préparation des données
        $membersList = $memberRepository->findAll();

        // TODO : préparer les données liées à l'entité User

        // On retourne les données des members au format Json
        return $this->render('back/member/index.html.twig', [
            'members' => $membersList,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods="GET", requirements={"id"="\d+"}) 
     */
    public function show($id, MemberRepository $memberRepository): Response
    {
        // préparation des données
        $member = $memberRepository->find($id);

        // Vérifier si le membre existe
        if (!$member) {
            throw $this->createNotFoundException('Membre non trouvé');
        }

        $user = $member->getUser();

        // Vérifier si l'utilisateur existe
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $email = $user->getEmail();
        $newsletter = $user->isNewsletter();

        // On retourne les données du member au format Json
        return $this->render('back/member/show.html.twig', [
            'member' => $member,
            'email' => $email,
            'newsletter' => $newsletter,  
        ]);
    }
}
