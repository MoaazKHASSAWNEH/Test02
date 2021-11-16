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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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


        $path = "article/index.html.twig";
        $param = [
            'articles' => $articles,
        ];

        return $this->render($path, $param);
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

    // /**
    //  * @Route("/new", name="article_new")
    //  */

    // public function new(EntityManagerInterface $manager) : Response 
    // {
    //     $article = new Article(); 

    //     $article->setTitre("new")
    //         ->setResume("c'est un resume d'un nouvel article")
    //         ->setDate( new \DateTime())
    //         ->setContenu("c'est le contenu du nouvel article"); 

    //         $manager->persist($article); 
    //         $manager->flush(); 

    //         $vue = "article/new.html.twig";
    //         $param = ["article" => $article]; 

    //         return $this->render($vue,$param); 

    // }

    /**
     * @Route("/nouvelarticle", name="article_nouvelarticle", methods={"GET","POST"})
     */
    // Ici on Fait une Enregistrement avec une Formulaire

    public function formArticle(Request $request, EntityManagerInterface $manager)
    {
        $article = new Article(); // Instanciation
        
        // Creation de mon Formulaire
        $form = $this->createFormBuilder($article)
            ->add('titre')
            ->add('resume')
            ->add('contenu')
            ->add('date')
            ->add('image')

            // Demande le résultat
            ->getForm();

        // Analyse des Requetes & Traitement des information 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {    
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_index');
        }
        

        // Redirection du Formulaire vers le TWIG pour l’affichage avec
        $vue = 'article/new2.html.twig';
        $param = ['formArticle' => $form->createView()];
        return $this->render($vue, $param);
    }

    /**
     * @Route("/{id}", name="article_id",  methods={"GET"})
     */

    public function affichage(Article $articles): Response
    {
        return $this->render('article/affichage.html.twig', [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit")
     */

    public function edit(Request $request,EntityManagerInterface $manager,Article $article) :Response
    {
        $form = $this->createFormBuilder($article)
            ->add('titre')
            ->add('resume')
            ->add('contenu')
            ->add('date',DateType::class)
            ->add('image')

            // Demande le résultat
            ->getForm();

        // Analyse des Requetes & Traitement des information 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {    
            // $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_index');
        }
        

        // Redirection du Formulaire vers le TWIG pour l’affichage avec
        $vue = 'article/new2.html.twig';
        $param = ['formArticle' => $form->createView()];
        return $this->render($vue, $param);
    }

    /**
     * @Route("/{id}/delete", name="article_delete")
     */

    public function delete(Request $request,EntityManagerInterface $manager,Article $article) : Response
    {
        $manager->remove($article); 
        $manager->flush(); 

        return $this->redirectToRoute("article_index"); 
    }

}
