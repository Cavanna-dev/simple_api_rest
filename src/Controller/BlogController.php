<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends Controller
{
    /**
     * @Route("/blog/articles", name="blog_list")
     */
    public function listAction()
    {
        try {
            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        } catch (\Exception $e) {
            // We do not expose internal errors to users
            throw new Exception('An errod occured.');
        }

        return $this->render(
            'article/list.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }

    /**
     * @Route("/blog/article/{id}", requirements={"id"="\d+"}, name="blog_get")
     */
    public function getAction(int $id)
    {
        try {
            $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(
                [
                    "id" => $id,
                ]
            );
        } catch (\Exception $e) {
            throw $this->createNotFoundException('This page does not exist');
        }

        return $this->render(
            'article/get.html.twig',
            [
                'article' => $article,
            ]
        );
    }
}