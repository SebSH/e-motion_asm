<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="_detail", methods={"POST","GET"})
     * @param User $user
     * @return Response
     */
    public function showUser(User $user): Response
    {
        $repository = $this->getDoctrine()->getRepository(Vehicle::class);
        $user = $repository->find($id);
        return $this->render('admin/showUser.html.twig', [
            'user' => $user,
        ]);
    }
}

