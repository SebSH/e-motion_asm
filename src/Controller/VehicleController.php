<?php
namespace App\Controller;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route(path="/vehicle",name="vehicle_app")
     */
    public function vehicle(Request $request): Response
    {
        $isOk = false;
        /** @var Vehicle $vehicle */
        $vehicle = new Vehicle();
        $newVehicleForm = $this->createForm(VehicleType::class, $vehicle);
        $newVehicleForm->handleRequest($request);
        if ($newVehicleForm->isSubmitted() && $newVehicleForm->isValid()) {
        
            $em = $this->getDoctrine()->getManager();
            $vehicle = $newVehicleForm->getData();
            $vehicle->setAvailable(1);
            $vehicle->setPurchaseDate(new \DateTime());
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

