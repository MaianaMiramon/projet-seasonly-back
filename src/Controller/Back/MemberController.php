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
     * @Route("/update/{id}", name="update", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function update($id, Request $request, Member $member, MemberRepository $memberRepository): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $memberRepository->add($member, true);

            return $this->redirectToRoute('app_back_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/member/update.html.twig', [
            'member' => $member,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods="POST", requirements={"id"="\d+"}) 
     */
    public function delete(Request $request, Member $member, MemberRepository $memberRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $member->getId(), $request->request->get('_token'))) {
            $memberRepository->remove($member, true);
            $this->addFlash('success', 'Membre supprimé');
        }

        return $this->redirectToRoute('app_back_member_index', [], Response::HTTP_SEE_OTHER);
    }
}