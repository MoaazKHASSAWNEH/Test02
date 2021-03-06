<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Article;
use App\Form\AuteurType;
use App\Entity\Categorie;
use App\Form\ArticleType;

use App\Entity\Commentaire;
use App\Entity\Serch;
use App\Form\CategorieType;
use App\Form\CommentaireType;
use App\Form\SerchType;
use Doctrine\ORM\EntityManager;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Egulias\EmailValidator\Parser\Comment;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\Types\AbstractList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="article_index", methods={"GET","POST"})
     */

    public function index(Request $request, PaginatorInterface $paginator, ArticleRepository $artRepo) 
    {    
        $ser = new Serch(); 
        $serForm = $this->createForm(SerchType::class, $ser) 
            ->add("Rechercher",SubmitType::class); 
        $serForm ->handleRequest($request);
        if ($serForm->isSubmitted() && $serForm->isValid())
        {
            $data = $artRepo->rechercheTitre($serForm["titre"]->getData());
            $articles = $paginator->paginate($data,$request->query->getInt("page",1),25); 
        } else {
            $data = $artRepo->findAll();
            $articles = $paginator->paginate($data,$request->query->getInt("page",1),25);
        }

        

        $path = "article/index.html.twig";
        $param = [
            'articles' => $articles,
            'ser_form' => $serForm->createView(),
            'request' => $request,  
        ];

        return $this->render($path, $param);
    }

    // /**
    //  * @Route("/{id}", name="article_id")
    //  */

    // public function affichage($id)
    // {
    //     $repo = $this->getDoctrine()->getRepository(Article::class); 
    //     $article = $repo->   find($id); 

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
        $form = $this->createForm(ArticleType::class,$article);

        // Analyse des Requetes & Traitement des information 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {    
            $article->setDate(new \DateTime()); 
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_index');
        }
        

        // Redirection du Formulaire vers le TWIG pour l???affichage avec
        $vue = 'article/new2.html.twig';
        $param = ['form' => $form->createView()];
        return $this->render($vue, $param);
    }

    /**
     * @Route("/{slug}", name="article_id",  methods={"GET","POST"})
     */

    public function affichage(Article $articles, Request $request,EntityManagerInterface $manager): Response
    {
        $commentaire = new Commentaire(); 

        $formCommentaire = $this->createForm(CommentaireType::class,$commentaire); 
        $formCommentaire->handleRequest($request); 

        if ($formCommentaire->isSubmitted() && $formCommentaire->isValid())
        {
            $commentaire->setDate(new \DateTime());
            $manager->persist($commentaire); 
            $articles->addCommentaire($commentaire);
            $manager->flush();
            return $this->redirectToRoute("article_id",["id" => $articles->getId()]);
        }

        return $this->render('article/affichage.html.twig', [
            "articles" => $articles,
            "form_commentaire" => $formCommentaire->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit")
     */

    public function edit(Request $request,EntityManagerInterface $manager,Article $article) :Response
    {
        $form = $this->createForm(ArticleType::class, $article); 
            

        // Analyse des Requetes & Traitement des information 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {    
            // $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_index');
        }
        

        // Redirection du Formulaire vers le TWIG pour l???affichage avec
        $vue = 'article/new2.html.twig';
        $param = ['form' => $form->createView()];
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
