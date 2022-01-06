<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
    *@Route("/admin/categories", name="admin_categories")
    */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
    *@Route("/admin/category/create", name="admin_category_create")
    */
    public function createCategory(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {       
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($category); 
                $manager->flush(); 
                $this->addFlash('success','La catégorie a bien été ajoutée');

                return $this->redirectToRoute('admin_categories');
                
            } else {
                $this->addFlash('danger', 'Une erreur est survenue lors de la création de la catégorie');
            }
        }

        return $this->render('admin/categoryForm.html.twig', [
            'categoryForm' => $form->createView(),
        ]);
    }
}
