<?php

namespace App\Controller\Back;

use App\Entity\Content;
use App\Form\Back\ContentType;
use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/content", name="app_back_content_")
 */
class ContentController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ContentRepository $contentRepository): Response
    {
        // dump($contentRepository->getContentSortByRecipeName());
        return $this->render('back/content/index.html.twig', [
            'contents' => $contentRepository->getContentSortByRecipeName(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, ContentRepository $contentRepository): Response
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contentRepository->add($content, true);

            return $this->redirectToRoute('app_back_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/content/create.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Content $content): Response
    {
        return $this->render('back/content/show.html.twig', [
            'content' => $content,
        ]);
    }

    /**
     * @Route("/{id}/update", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, Content $content, ContentRepository $contentRepository): Response
    {
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contentRepository->add($content, true);

            return $this->redirectToRoute('app_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/content/update.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Content $content, ContentRepository $contentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$content->getId(), $request->request->get('_token'))) {
            $contentRepository->remove($content, true);
        }

        return $this->redirectToRoute('app_back_content_index', [], Response::HTTP_SEE_OTHER);
    }
}
