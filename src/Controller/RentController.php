<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Form\RentType;
use App\Entity\User;
use App\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/rent", name="rent")
*/
class RentController extends AbstractController
{
    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request): Response
    {
        $isOk = false;
        
        $newRentForm = $this->createForm(RentType::class);
        $newRentForm->handleRequest($request);
        if ($newRentForm->isSubmitted() && $newRentForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $newRent = new Rent();
            $id = $request->get("id");
            $rent = $request->request->get("Rent");
            $startDate = $rent["start_date"];
            $endDate = $rent["end_date"];
            $this->denyAccessUnlessGranted('ROLE_USER');
            $user = $this->getUser()->getId();
            $newRent->setIdVehicle($id);
            $newRent->setStartDate($startDate);
            $newRent->setEndDate($endDate);
            $newRent->setIdUser($user);
            $em->persist($newRent);
            $em->flush();
            $isOk = true;
            return $this->redirectToRoute('meeting_list');
        }
        return $this->render(
            'rent/add.html.twig',
            [
            'rentForm' => $newRentForm->createView(),
            'isOk' => $isOk,
            ]
        );
    }
}
