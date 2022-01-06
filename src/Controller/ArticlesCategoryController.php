<?php

namespace App\Controller;

use App\Entity\ArticlesCategory;
use App\Form\ArticleCategoryType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticlesCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesCategoryController extends AbstractController
{
    /**
     * @Route("/admin/articles/category", name="admin_articles_category")
     */
    public function index(ArticlesCategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/articlesCategory.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/articles/category/create", name="admin_articles_category_create")
     */
    public function create(Request $request)
    {
        $category = new ArticlesCategory();
        $form = $this->createForm(ArticleCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('message', 'La catégorie a été crée avec succès');

            return $this->redirectToRoute('admin_articles_category');
        }

        return $this->render('admin/articlesCategoryForm.html.twig', [
            'form' => $form->createView()
        ]);

        
    }

    /**
     * @Route("/admin/articles/category/update/{id}", name="admin_articles_category_update")
     */
    public function update(ArticlesCategoryRepository $categoryRepository, $id, Request $request)
    {
        $category = $categoryRepository->find($id);
        $form = $this->createForm(ArticleCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('message', 'La catégorie a été modifiée avec succès');

            return $this->redirectToRoute('admin_articles_category');
        }

        return $this->render('admin/articlesCategoryForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/admin/articles/category/delete/{id}", name="admin_articles_category_delete")
     */
    public function delete(ArticlesCategoryRepository $categoryRepository, $id)
    {
        $category = $categoryRepository->find($id);
        

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash('message', 'La catégorie a été supprimée avec succès');

            return $this->redirectToRoute('admin_articles_category');
        
    }


}
