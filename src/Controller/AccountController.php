<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $id = $this->getUser()->getId();
        $user = $repository->find($id);
        return $this->render('user/userAccount.html.twig', [
            'user' => $user,
        ]);
    }
}
