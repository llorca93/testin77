<?php

namespace App\Controller;

use App\Entity\ClientsCategory;
use App\Form\ClientsCategoryType;
use App\Repository\ClientsCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientsCategoryController extends AbstractController
{
    /**
     * @Route("/admin/clients/category", name="admin_clients_category")
     */
    public function index(ClientsCategoryRepository $clientsCatRepository): Response
    {
        $categories = $clientsCatRepository->findAll();

        return $this->render('admin/clientsCategory.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/clients/category/create", name="admin_clients_category_create")
     */
    public function create(Request $request)
    {
        $category = new ClientsCategory();
        $form = $this->createForm(ClientsCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('message', 'La catégorie a bien été ajoutée');

            return $this->redirectToRoute('admin_clients_category');
        }

        return $this->render('admin/clientsCategoryForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/clients/category/update/{id}", name="admin_clients_category_update")
     */
    public function update(ClientsCategoryRepository $clientsRepository, $id, Request $request)
    {
        $category = $clientsRepository->find($id);
        $form = $this->createForm(ClientsCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('message', 'La catégorie a été modifiée avec succès');

            return $this->redirectToRoute('admin_clients_category');
        }

        return $this->render('admin/clientsCategoryForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/admin/clients/category/delete/{id}", name="admin_clients_category_delete")
     */
    public function delete(ClientsCategoryRepository $clientsRepository, $id)
    {
        $category = $clientsRepository->find($id);
        

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash('message', 'La catégorie a été supprimée avec succès');

            return $this->redirectToRoute('admin_clients_category');
        
    }
}
