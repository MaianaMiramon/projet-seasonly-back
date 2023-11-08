<?php

namespace App\Controller\Api;

use App\Entity\Member;
use App\Form\Member1Type;
use App\Repository\MemberRepository;
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
 * @Route("/api/member")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="api_member_browse")
     */
    public function browse(MemberRepository $memberRepository): JsonResponse
    {
        $membersList = $memberRepository->findAll();

        return $this->json([
            'members' => $membersList,
        ], Response::HTTP_OK, [], ["groups" => "member_list"]);
    }

    /**
     * @Route("/add", name="api_member_create", methods="POST")
     */
    public function create(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // récupération des données en json
        $json = $request->getContent();

        dump($json);

        $member = $serializer->deserialize($json, Member::class, 'json');

        $errorList = $validator->validate($member);
        if (count($errorList) > 0)
        {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($member);
        $em->flush();

        return $this->json($member, Response::HTTP_CREATED, [], ["groups" => "member_create"]);
    }

    /**
     * @Route("/{id}", name="api_member_delete", methods="DELETE")
     */
    public function delete($id, EntityManagerInterface $em): JsonResponse
    {
        // pour supprimer une ligne en BDD, il faut
        // récupérer l'entité depuis la BDD
        $member = $em->find(Member::class, $id);

        if ($member === null)
        {
            $errorMessage = [
                'message' => "Member not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        // lancer $em->remove($monEntite)
        $em->remove($member);

        // + flush pour exécuter les requêtes
        $em->flush();

        return $this->json("Membre supprimé");
    }

    /**
     * @Route("/{id}", name="api_member_read", methods="GET", requirements={"id"="\d+"})
     */
    public function read($id, MemberRepository $memberRepository): JsonResponse
    {
        // comme le param converte
        $member = $memberRepository->find($id);

        if ($member === null)
        {
            $errorMessage = [
                'message' => "Member not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'movie' => $member,
        ], Response::HTTP_OK, [], ["groups" => "member_read"]);
        
    }

    /**
     * @Route("/{id}", name="api_member_update", methods="PUT", requirements={"id"="\d+"})
     */
    public function update($id, EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $member = $em->find(Member::class, $id);

        if ($member === null)
        {
            $errorMessage = [
                'message' => "Member not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        // on traite les données recues en json
        $json = $request->getContent();

        $serializer->deserialize($json, Member::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $member]);

        $errorList = $validator->validate($member);
        if (count($errorList) > 0)
        {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }
        // pas besoin de persist car on a fait un find
        // $em->persist($movie);
        $em->flush();

        // on renvoit une réponse
        return $this->json($member, Response::HTTP_OK, [], ["groups" => 'member_update']);
    }
}