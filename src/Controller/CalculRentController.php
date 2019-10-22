<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Form\RentType;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Controller\CalculDuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CalculRentController extends AbstractController
{
    /**
     * @Route("/calcul", name="calcul_rent", methods={"POST", "GET"})
     */
    public function index(Request $request): Response
    {
        
        $newRentForm = $this->createForm(RentType::class);
        $newRentForm->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $newRent = new Rent();
            $rent = $request->request->get("Rent");
            $startDate = $rent["start_date"];
            $endDate = $rent["end_date"];
            $calculDuration = new CalculDuration();
            $duration = $calculDuration->duration($endDate, $startDate, $differenceFormat = '%a');
            $user = $this->getUser()->getId();
            $em->persist($newRent);
        
        return $this->render(
            'calcul_rent/index.html.twig',
            [
            'rentForm' => $newRentForm->createView(),
            ]
        );
    }
}
