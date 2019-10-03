<?php


namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends abstractController
{
    /**
     * @Route("/",name="website_index")
     */
    public function index(){
        return $this->render('home/home.html.twig');
    }
}