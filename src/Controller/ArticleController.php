<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/articles", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $article = new Article($data['title'], $data['description']);

        $validator = $this->get('validator');
        $errors = $validator->validate($article);

        if (count($errors) > 0) {
            return $this->generateApiError();
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();

        return $this->json(
            [
                "data" => $article,
            ]
        );
    }

    /**
     * @Route("/articles/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getAction(int $id): Response
    {
        try {
            $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(
                [
                    "id" => $id,
                ]
            );
        } catch (\Exception $e) {
            return $this->generateApiError();
        }

        return $this->json(
            [
                "data" => $article,
            ]
        );
    }

    /**
     * @Route("/articles", methods={"GET"})
     */
    public function listAction(): Response
    {
        try {
            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        } catch (\Exception $e) {
            return $this->generateApiError();
        }

        return $this->json(
            [
                "data" => $articles,
            ]
        );
    }

    /**
     * We return explicitly code and message because we do not want to expose internal data to the user
     */
    private function generateApiError(): array
    {
        return $this->json(
            [
                "error" => [
                    "code" => 404,
                    "message" => "An error has occured.",
                ]
            ]
        );
    }
}