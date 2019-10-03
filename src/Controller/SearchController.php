<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Vehicle::class);
        $vehicles = $repository->findByVehicule();
            
        dump($request->request->all());
        return $this->render('search/search.html.twig', [
            'vehicles' => $vehicles,
            'start_date'=> 1,
        ]);
    }
}
