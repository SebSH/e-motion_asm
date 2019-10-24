<?php

namespace App\Controller;
use App\Entity\Rent;
use App\Form\RentType;
use App\Repository\RentRepository;
use App\Entity\User;
use App\Entity\Vehicle;
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
    public function add(Request $request): Response
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
            $newRent->setIdVehicle($id);
            $newRent->setStartDate($start_date);
            $newRent->setEndDate($end_date);            
            $newRent->setIdUser($user);
            $em->persist($newRent);
            $em->flush();
            $isOk = true;
            return $this->redirectToRoute('website_index');
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