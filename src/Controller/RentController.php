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
        if (isset($_POST["start_date"]) && isset($_POST["end_date"])) {
            $em = $this->getDoctrine()->getManager();
            $newRent = new Rent();
            // $rentRepositorysitory = $this->getDoctrine()->getRepository(Rent::class);
            $id = $request->get("id");
            $rent = $request->request->get("rent");
            $startDate = $_POST["start_date"];
            $endDate = $_POST["end_date"];
            // $duration = $rentRepositorysitory->addDuration();
            // $duration = implode($duration);
            // $duration = intval($duration);
            $this->denyAccessUnlessGranted('ROLE_USER');
            $user = $this->getUser()->getId();
            $newRent->setIdVehicle($id);
            $newRent->setStartDate(new \DateTime($startDate));
            $newRent->setEndDate(new \DateTime($endDate));            
            $newRent->setIdUser($user);
            var_dump($_POST['start_date']);
            exit;
            $em->persist($newRent);
            $em->flush();
            $isOk = true;
            return $this->redirectToRoute('website_index');
        }
        
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