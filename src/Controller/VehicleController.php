<?php

namespace App\Controller;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/vehicle", name="vehicle")
 */
class VehicleController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $isOk = false;
        /** @var Vehicle $Vehicle */
        $vehicle = new Vehicle();
        $newVehicleForm = $this->createForm(VehicleType::class, $vehicle);
        $newVehicleForm->handleRequest($request);
        if ($newVehicleForm->isSubmitted() && $newVehicleForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $vehicle = $newVehicleForm->getData();
            $vehicle->setAvailable(1);
            $em->persist($vehicle);
            $em->flush();
            $isOk = true;
        }
        return $this->render('vehicle/add.html.twig', [
            'vehicleInscriptionForm' => $newVehicleForm->createView(),
            'isOk' => $isOk
        ]);
    }
}
