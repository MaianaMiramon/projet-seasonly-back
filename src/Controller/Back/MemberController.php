<?php

namespace App\Controller\Back;

use App\Entity\Member;
use App\Form\Back\MemberType;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/update/{id}", name="update", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function update($id, Request $request, Member $member, MemberRepository $memberRepository): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $memberRepository->add($member, true);

            return $this->redirectToRoute('app_back_vegetable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/member/update.html.twig', [
            'member' => $vegetable,
            'form' => $form,
        ]);
    }
}