<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    public function apropos(): Response 
    {
        return $this->render('home/apropos.html.twig', [
            'controller_name' => 'HomeController' ,
        ]);
    }

    public function contact(): Response 
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController' ,
        ]);
    }

    /**
     * @Route("/programme", name="programme")
     */

    public function programme()
    {
        return $this->render('home/programme.html.twig' , [
            'controller_nam' => 'HomeController',
        ]); 
    }
}
