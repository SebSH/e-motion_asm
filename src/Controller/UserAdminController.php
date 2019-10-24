<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserAdminType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAdminController extends AbstractController
{
    /**
     * @Route("/user/admin", name="user_admin")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return $this->render('admin/userAdmin.html.twig', [
            'controller_name' => 'UserAdminController',
        ]);
    }

    /**
     * @Route("admin/user/list", name="admin_user_list", methods={"POST","GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function listUser(UserRepository $userRepository): Response
    {
        return $this->render('admin/listUser.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/new/user", name="admin_user_new", methods={"POST","GET"})
     * @param Request $request
     * @return Response
     */
    public function newUser(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $roles = $user->getRoles();
        $form = $this->createForm(UserAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_admin');
        }

        return $this->render('admin/newUser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="admin_user_detail", methods={"POST","GET"})
     * @param User $user
     * @return Response
     */
    public function showUser(User $user): Response
    {
        return $this->render('admin/showUser.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("admin/user/edit/{id}", name="admin_user_edit", methods={"POST","GET"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_list', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('admin/editUser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param User $user
     * @return Response
     * @Route("admin/user/delete/{id}", name="admin_user_delete", methods={"GET"})
     */

    public function delete(User $user): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_user_list');
    }
}