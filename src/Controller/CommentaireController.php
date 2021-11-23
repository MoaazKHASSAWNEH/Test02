<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use phpDocumentor\Reflection\Types\AbstractList;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Route("/commentaire")
 */

class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="commentaire_index")
     */

    public function index(CommentaireRepository $repo) : Response
    {
        // $repo = $this->getDoctrine()
        // ->getRepository(commentaire::class); 
        // $commentaires = $repo->findAll(); 

        $commentaires = $repo->findAll(); 

        $vue="commentaire/index.html.twig"; 
        $param=['commentaires'=>$commentaires,
        ]; 

        return $this->render($vue,$param); 
    }

    /**
     * @Route("/new", name="commentaire_new")
     */

    public function newWithType(Request $request,EntityManagerInterface $manager)
    {
        $commentaire = new Commentaire();
        $commentaire->setDate(new \DateTime()); 
        $form = $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($commentaire);
            $manager->flush(); 

            return $this->redirectToRoute("commentaire_index");  
        }

        $vue = "commentaire/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param);        
    }


    /**
     * @Route("/{id}", name="commentaire_id",  methods={"GET"})
     */

    public function affichage(Commentaire $commentaire) : Response 
    {
        return $this->render('commentaire/affichage.html.twig', [
            "commentaire" => $commentaire
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commentaire_edit")
     */

    public function edit(EntityManagerInterface $manager, Request $request, commentaire $commentaire) : Response
    {
        $form = $this->createForm(CommentaireType::class,$commentaire); 
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            // $manager->persist($commentaire);
            $manager->flush(); 

            return $this->redirectToRoute("commentaire_index");  
        }

        $vue = "commentaire/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param);
    }

    /**
     * @Route("/{id}/delete", name="commentaire_delete")
     */

    public function delete(Request $request,Commentaire $commentaire,EntityManagerInterface $manager) : Response
    {
        $manager->remove($commentaire);
        $manager->flush();
        return $this->redirectToRoute("commentaire_index");    
    }
}