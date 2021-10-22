<?php 

namespace App\Controller;

use phpDocumentor\Reflection\Types\AbstractList;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu")
 */

class MenuController extends AbstractController
{

    /**
     * @Route("/", name="menu_accueil")
     */

    public function accueil() 
    {
        $path = "menu/accueil.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

    /**
     * @Route("/about", name="menu_about")
     */

    public function about() 
    {
        $path = "menu/about.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

    /**
     * @Route("/livre", name="menu_livre")
     */

    public function livre() 
    {
        $path = "menu/livre.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

    /**
     * @Route("/location", name="menu_location")
     */

    public function location() 
    {
        $path = "menu/location.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

    /**
     * @Route("/documentation", name="menu_documentation")
     */

    public function documentation() 
    {
        $path = "menu/documentation.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

    /**
     * @Route("/nous-contacter", name="menu_contact")
     */

    public function nous_contacter() 
    {
        $path = "menu/contact.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

    /**
     * @Route("/connexion", name="menu_connexion")
     */

    public function connexion() 
    {
        $path = "menu/connexion.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

    /**
     * @Route("/administration", name="menu_administration")
     */

    public function administration() 
    {
        $path = "menu/administration.html.twig"; 
        $param = []; 

        return $this->render($path,$param); 
    }

}