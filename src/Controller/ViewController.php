<?php 

namespace App\Controller;

use phpDocumentor\Reflection\Types\AbstractList;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
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

    /**
     * @Route("/operation", name="operation")
     */

    public function operation() 
    {
        $route = "view/operation.html.twig"; 
        $params = []; 

        return $this->render($route,$params); 
    }

    /**
     * @Route("/condition", name="condition")
     */

    public function condition()
    {
        $route = "view/condition.html.twig"; 
        $params = []; 

        return $this->render($route,$params); 
    }

    /**
     * @Route("/boucle", name="boucle")
     */

    public function boucle()
    {
        $route = "view/boucle.html.twig";
        $params = []; 

        return $this->render($route,$params); 
    }

    /**
     * @Route("/exo4", name="exo4")
     */

    public function exo4()
    {
        $route = "view/exo4.html.twig"; 
        $params = []; 

        return $this->render($route,$params);
    }

    /**
     * @Route("/exo5", name="exo5")
     */

    public function exo5()
    {
        $route = "view/exo5.html.twig"; 
        $params = []; 

        return $this->render($route,$params);
    }

    /**
     * @Route("/exo6", name="exo6")
     */

    public function exo6()
    {
        $route = "view/exo6.html.twig"; 
        $params = []; 

        return $this->render($route,$params);
    }

    /**
     * @Route("/filtre", name="filtre")
     */

    public function filtre()
    {
        $route = "view/filtre.html.twig"; 
        $params = []; 

        return $this->render($route,$params);
    }

}


?>