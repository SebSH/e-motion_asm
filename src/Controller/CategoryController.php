<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/category", name="category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $isOk = false;
        /** @var Category $category */
        $category = new Category();
        $newCategoryForm = $this->createForm(CategoryType::class, $category);
        $newCategoryForm->handleRequest($request);
        if ($newCategoryForm->isSubmitted() && $newCategoryForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category = $newCategoryForm->getData();
            $em->persist($category);
            $em->flush();
            $isOk = true;
        }
        return $this->render('category/add.html.twig', [
            'categoryInscriptionForm' => $newCategoryForm->createView(),
            'isOk' => $isOk
        ]);
    }


    /**
     * @param Request $request
     * @param Category $category
     * @Route(path="/edit/{id}", name="edit")
     */
    public function edit(Request $request, Category $category): Response
    {
        $isOk = false;
        $newCategoryForm = $this->createForm(CategoryType::class, $category);
        $newCategoryForm->handleRequest($request);
        if ($newCategoryForm->isSubmitted() && $newCategoryForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $isOk = true;
        }
        return $this->render(
            'category/edit.html.twig',
            [
                'categoryForm' => $newCategoryForm->createView(),
                'isOk' => $isOk
                ]
        );
    }

    /**
     * @param Category $category
     * @return Response
     * @Route(path="/delete/{id}", name="delete")
     */
     public function delete(Category $category): Response
     {
         $em = $this->getDoctrine()->getManager();
         $em->remove($category);
         $em->flush();
         return $this->redirectToRoute('category');
     }

    /**
    * @Route(path="/list" ,name="list")
    */
    public function list(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        return $this->render(
            'category/list.html.twig',
            [
                'categories' => $repository->findAll(),
            ]
        );
    }


}
