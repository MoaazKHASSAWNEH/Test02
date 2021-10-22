<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;

use phpDocumentor\Reflection\Types\AbstractList;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\EntityManagerInterface; 

/**
 * @Route("/article")
 */

class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="article_index")
     */

    public function index() 
    {
        $repo = $this->getDoctrine()
                    ->getRepository(Article::class); 
        $articles = $repo->findAll(); 


        $path="article/index.html.twig"; 
        $param=['articles'=>$articles,
        ]; 

        return $this->render($path,$param); 
    }

    // /**
    //  * @Route("/{id}", name="article_id")
    //  */

    // public function affichage($id)
    // {
    //     $repo = $this->getDoctrine()->getRepository(Article::class); 
    //     $article = $repo->find($id); 

    //     $path = "article/affichage.html.twig";
    //     $param = [
    //         'article'=>$article,
    //     ]; 
        
    //     if ($article === null)
    //         return $this->redirectToRoute("article_index");

    //     return $this->render($path,$param); 
    // }

     /**
     * @Route("/{ id }", name="article_id",  methods={"GET"})
     */

    public function affichage(Request $request, ArticleRepository $articlesRepository, EntityManager $manager, Article $articles) : Response 
    {
        return $this->render('article/nouveau.html.twig', [
            'id' =>$articles->getId(),
            "article" => $article
        ]);
    }
}