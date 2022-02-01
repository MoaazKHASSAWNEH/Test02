<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\LocationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/article", name="api_article_")
 */

class ApiArticleController extends AbstractController
{
    /**
     * @Route("/", name="liste", methods = {"GET"})
     */
    public function index(ArticleRepository $article,SerializerInterface $ser): Response
    {
        return $this->json($ser->serialize($article->findAll(),"json",[AbstractNormalizer::IGNORED_ATTRIBUTES => ["articles","article"]]), 200);
    }
}
