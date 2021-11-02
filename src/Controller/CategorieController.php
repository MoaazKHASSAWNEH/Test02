<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategoreReposetory;

use phpDocumentor\Reflection\Types\AbstractList;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\EntityManagerInterface; 

/**
 * @Route("/categorie")
 */

class CategorieController extends AbstractController
{

    /**
     * @Route("/", name="index_categorie")
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
     * @Route("/{id}", name="categorie_id",  methods={"GET"})
     */

    public function affichage(Categorie $categorie) : Response 
    {
        return $this->render('categorie/affichage.html.twig', [
            'id' =>$categorie->getId(),
            "categorie" => $categorie
        ]);
    }
}