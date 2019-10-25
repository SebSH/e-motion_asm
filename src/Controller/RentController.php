<?php

namespace App\Controller;
use App\Entity\Rent;
use App\Form\RentType;
use App\Repository\RentRepository;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \Datetime;
/**
 * @Route("/rent", name="rent")
*/
class RentController extends AbstractController
{
    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request, VehicleRepository $vehicleRepository): Response
    {
        $isOk = false;
        
        $newRentForm = $this->createForm(RentType::class);
        $newRentForm->handleRequest($request);
        if ($newRentForm->isSubmitted() && $newRentForm->isValid()) {
            $date = $newRentForm->getData();
            $em = $this->getDoctrine()->getManager();
            $newRent = new Rent();
            $id = $request->get("id");
            $rent = $request->request->get("rent");
            $this->denyAccessUnlessGranted('ROLE_USER');
            $user = $this->getUser()->getId();
            $start = implode("-", $rent['start_date']);
            $start_date = new DateTime( $start);
            $end = implode("-", $rent['end_date']);
            $end_date = new DateTime( $end);
            $interval = $start_date->diff($end_date)->format('%a');
            $duration = intval($interval);
            $temp_daily_price = $vehicleRepository->findDailyPrice($id);
            foreach($temp_daily_price as $t){
                $daily_price = $t;
            }
            $daily_price = implode($daily_price, " ");
            $temp_rental_price = $vehicleRepository->findRentalPrice($id);
            foreach($temp_rental_price as $t){
                $rental_price = $t;
            }
            $rental_price  = implode($rental_price, " ");
            $price = intval($rental_price + ($daily_price * $duration));

            $newRent->setIdVehicle($id);
            $newRent->setStartDate($start_date);
            $newRent->setEndDate($end_date);
            $newRent->setDuration($duration);
            $newRent->setPrice($price);            
            $newRent->setIdUser($user);
            $em->persist($newRent);
            $em->flush();
            $isOk = true;
            return $this->redirectToRoute('rent_list');
        }

        return $this->render(
            'rent/add.html.twig',
            [
            'rentForm' => $newRentForm->createView(),
            ]
        );
        
    }

    /**
     * @Route("/list", name="_list")
     */
    public function list(RentRepository $rentRepository): Response
    {
        $rentRepository = $this->getDoctrine()->getManager()
        ->getRepository(Rent::class);
        
        $id = $this->getUser()->getId();
        
        $result = $rentRepository->findByUser($id);

        return $this->render('rent/list.html.twig', [
            'rents' => $result,
        ]);
    }
}