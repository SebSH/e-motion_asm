<?php
declare(strict_types = 1);

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
        $avlb = true;
        /** @var Vehicle $vehicle */
        $vehicle = new Vehicle();
        $newVehicleForm = $this->createForm(VehicleType::class, $vehicle);
        $newVehicleForm->handleRequest($request);
        if ($newVehicleForm->isSubmitted() && $newVehicleForm->isValid()) {
        
            $em = $this->getDoctrine()->getManager();
            $vehicle = $newVehicleForm->getData();
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $vehicle->setAvailable($avlb);
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

    /**
     * @Route("vehicle/edit/{id}", name="vehicle_edit", methods={"POST","GET"})
     * @param Request $request
     * @param Vehicle $vehicle
     * @return Response
     */
    public function update(Request $request, Vehicle $vehicle): Response
    {
        $isOk = false;
        $newVehicleForm = $this->createForm(VehicleType::class, $vehicle);
        $newVehicleForm->handleRequest($request);
        if ($newVehicleForm->isSubmitted() && $newVehicleForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $isOk = true;
        }
        
        return $this->render('vehicle/update.html.twig', [
            'vehicleForm' => $newVehicleForm->createView(),
            'isOk' => $isOk
        ]);
    }

    /**
     * @param Vehicle $vehicle
     * @return Response
     * @Route("car/delete/{id}", name="car_delete", methods={"GET"})
     */

    public function deleteCar(Vehicle $vehicle): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($vehicle);
        $em->flush();
        return $this->redirectToRoute('car');
    }

     /**
     * @param Vehicle $vehicle
     * @return Response
     * @Route("scooter/delete/{id}", name="scooter_delete", methods={"GET"})
     */

    public function deleteScooter(Vehicle $vehicle): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($vehicle);
        $em->flush();
        return $this->redirectToRoute('scooter');
    }

    /**
     * @Route("/car", name="car")
     */
    public function listCar(VehicleRepository $vehicleRepository): Response
    {
        $vehicleRepository = $this->getDoctrine()->getManager()
        ->getRepository(Vehicle::class);
        
        $result = $vehicleRepository->findCar();

        return $this->render('vehicle/car.html.twig', [
            'cars' => $result,
        ]);

    }

    /**
     * @Route("/scooter", name="scooter")
     */
    public function listScooter(VehicleRepository $vehicleRepository): Response
    {
        $vehicleRepository = $this->getDoctrine()->getManager()
        ->getRepository(Vehicle::class);
        
        $result = $vehicleRepository->findScooter();

        return $this->render('vehicle/scooter.html.twig', [
            'cars' => $result,
        ]);

    }
}

