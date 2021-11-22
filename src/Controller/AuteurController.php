<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
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
 * @Route("/auteur")
 */

class AuteurController extends AbstractController
{
    /**
     * @Route("/", name="auteur_index")
     */

    public function index(AuteurRepository $repo) : Response
    {
        // $repo = $this->getDoctrine()
        // ->getRepository(auteur::class); 
        // $auteurs = $repo->findAll(); 

        $auteurs = $repo->findAll(); 

        $vue="auteur/index.html.twig"; 
        $param=['auteurs'=>$auteurs,
        ]; 

        return $this->render($vue,$param); 
    }

    /**
     * @Route("/new", name="auteur_new")
     */

    public function newWithType(Request $request,EntityManagerInterface $manager)
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class,$auteur);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($auteur);
            $manager->flush(); 

            return $this->redirectToRoute("auteur_index");  
        }

        $vue = "auteur/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param);        
    }


    /**
     * @Route("/{id}", name="auteur_id",  methods={"GET"})
     */

    public function affichage(Auteur $auteur) : Response 
    {
        return $this->render('auteur/affichage.html.twig', [
            "auteur" => $auteur
        ]);
    }

    /**
     * @Route("/{id}/edit", name="auteur_edit")
     */

    public function edit(EntityManagerInterface $manager, Request $request, Auteur $auteur) : Response
    {
        $form = $this->createForm(AuteurType::class,$auteur); 
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            // $manager->persist($auteur);
            $manager->flush(); 

            return $this->redirectToRoute("auteur_index");  
        }

        $vue = "auteur/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param);
    }

    /**
     * @Route("/{id}/delete", name="auteur_delete")
     */

    public function delete(Request $request,Auteur $auteur,EntityManagerInterface $manager) : Response
    {
        $manager->remove($auteur);
        $manager->flush();
        return $this->redirectToRoute("auteur_index");    
    }
}