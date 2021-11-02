<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;

use phpDocumentor\Reflection\Types\AbstractList;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\EntityManagerInterface; 

/**
 * @Route("/utilisateur")
 */

class UtilisateurController extends AbstractController
{

    /**
     * @Route("/", name="utilisateur_index")
     */

    public function index() 
    {
        $repo = $this->getDoctrine()
                    ->getRepository(Utilisateur::class); 
        $utilisateurs = $repo->findAll(); 


        $vue="utilisateur/index.html.twig"; 
        $param=['utilisateurs'=>$utilisateurs,
        ]; 

        return $this->render($vue,$param); 
    }

    /**
     * @Route("/{id}", name="utilisateur_id")
     */

    public function affichage(Utilisateur $utilisateur) : Response
    {
        $vue = "utilisateur/affichage.html.twig";
        $param = ["utilisateur" => $utilisateur];
        
        return $this->render($vue,$param);
    }
}