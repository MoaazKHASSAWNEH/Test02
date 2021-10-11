<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    /**
     * @Route("/d", name="defaulte")
     */

    public function index() : Response 
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/testresponse/{id}", name="response")
     */

    public function response($id) 
    {
        //pour afficher un message (pas besoin de vue) 
        return new Response("<h1>Bonjour: $id bienvenue</h1>");
    }

    /**
     * @Route("/testrender/{id}/{age}", name="render")
     */

    public function testrender($id,$age)
    {
        //render a besoin toujours de vue !
        return $this->render("default/index.html.twig" ,array(
            'id'=>$id,
            'age' => $age,
        ));
    }

    /**
     * @Route("/testredirection", name="redirection_home")
     */

    public function testredirection() 
    {
        // Il faut donner le nom de la route pour rederiger sur cette route 
        // la rout dans cette examble est "/home"
        
        return $this->redirectToRoute('home');
    }

    

}

?> 