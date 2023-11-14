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
        $entityManager = $this->getDoctrine()->getManager();
        $member = $entityManager->getRepository(Member::class)->find($id);

        if (!$member) {
            throw $this->createNotFoundException('Membre non trouvé pour l\'id ' . $id);
        }

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les valeurs des champs non mappés
            $userEmail = $form->get('user_email')->getData();
            $userNewsletter = $form->get('user_newsletter')->getData();

            // Mettre à jour l'entité Member
            $member->setPseudo($form->get('pseudo')->getData());
            $member->setRoles($form->get('roles')->getData());

            // Vérifier si l'entité User est associée à Member
            $user = $member->getUser();
            if ($user) {
                // Mettre à jour l'entité User si elle existe
                $user->setEmail($userEmail);
                $user->setNewsletter($userNewsletter);
                // Vous pouvez ajouter d'autres mises à jour si nécessaire pour l'entité User
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_back_member_index');
        }

        return $this->render('back/member/update.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }
}