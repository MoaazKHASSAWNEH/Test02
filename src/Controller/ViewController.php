<?php 

namespace App\Controller;

use phpDocumentor\Reflection\Types\AbstractList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/view")
 */
class ViewController extends AbstractController
{
    
    /**
     * @Route("/", name="view_index")
     */

    public function index() : Response 
    {
        $template = "/view/index.html.twig";
        $params = ["controller_name" => "ViewController",
                   "creater" => "Moaaz"];
           
        return $this->render($template, $params);
    }

    /**
     * @Route("/momo", name="momo")
     */

    public function momo()
    {
        $template = "view/momo.html.twig"; 
        $params = [
            "title" => "Momo",
            "nom" => "KHASSAWNEH",
            "prenom" => "Moaaz", 
        ];
        
        return $this->render($template,$params); 
    }

    /**
     * @Route("/stagiaire", name="liste_stagiaires")
     */

    public function liste_stagiaire() 
    {
        $stagiaires = ["Ange","Moaaz","Modou","Valery","Fabrice"]; 
        $template = "view/liste_stagiaire.html.twig"; 
        $params = ["title" => "Liste de stagiaires", 
                   "stagiaires" => $stagiaires];
                   
        return $this->render($template,$params); 
    }
}


?>