<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
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
        $repository = $this->getDoctrine()->getRepository(User::class);
        $id = $request->get("id");
        $user = $repository->find($id);
        return $this->render('admin/showUser.html.twig', [
            'user' => $user,
        ]);
    }

     /**
     * @Route("/edit/{id}", name="_edit", methods={"POST","GET"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user): Response
    {
        $isOk = false;
        $newUserForm = $this->createForm(UserEditType::class, $user);
        $newUserForm->handleRequest($request);
        if ($newUserForm->isSubmitted() && $newUserForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $isOk = true;
        }
        
        return $this->render('user/update.html.twig', [
            'userForm' => $newUserForm->createView(),
            'isOk' => $isOk
        ]);
    }
}

