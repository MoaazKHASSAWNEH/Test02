<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategoreReposetory;

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
 * @Route("/categorie")
 */

class CategorieController extends AbstractController
{

    /**
     * @Route("/", name="categorie_index")
     */

    public function index() : Response
    {
        $repo = $this->getDoctrine()
                    ->getRepository(Categorie::class); 
        $categories = $repo->findAll(); 


        $vue="categorie/index.html.twig"; 
        $param=['categories'=>$categories,
        ]; 

        return $this->render($vue,$param); 
    }

    /**
     * @Route("/new", name="categorie_new", methods={"GET","POST"})
     */

    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $categorie = new Categorie(); 
        
        $form = $this->createFormBuilder($categorie)
            ->add("titre")
            ->add("resume")
        ->getForm();
        
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($categorie);
            $manager->flush(); 

            return $this->redirectToRoute("categorie_index");  
        }

        $vue = "categorie/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param); 

    }

    /**
     * @Route("/new2", name="categorie_new2")
     */

    public function newWithTpey(Request $request,EntityManagerInterface $manager)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($categorie);
            $manager->flush(); 

            return $this->redirectToRoute("categorie_index");  
        }

        $vue = "categorie/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param);        
    }


    /**
     * @Route("/{id}", name="categorie_id",  methods={"GET"})
     */

    public function affichage(Categorie $categorie) : Response 
    {
        return $this->render('categorie/affichage.html.twig', [
            "categorie" => $categorie
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_edit")
     */

    public function edit(EntityManagerInterface $manager, Request $request, Categorie $categorie) : Response
    {
        $form = $this->createForm(CategorieType::class,$categorie); 
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            // $manager->persist($categorie);
            $manager->flush(); 

            return $this->redirectToRoute("categorie_index");  
        }

        $vue = "categorie/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param);
    }

    /**
     * @Route("/{id}/delete", name="categorie_delete")
     */

    public function delete(Request $request,Categorie $categorie,EntityManagerInterface $manager) : Response
    {
        $manager->remove($categorie);
        $manager->flush();
        return $this->redirectToRoute("categorie_index");    

    }
}