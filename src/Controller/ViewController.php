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
}


?>