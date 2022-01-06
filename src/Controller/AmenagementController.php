<?php

namespace App\Controller;

use App\Entity\Amenagement;
use App\Form\AmenagementType;
use App\Repository\AmenagementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AmenagementController extends AbstractController
{
    /**
     * @Route("/admin/amenagement", name="admin_amenagement")
     */
    public function index(AmenagementRepository $amenagementRepository): Response
    {
        $amenagements = $amenagementRepository->findAll();

        return $this->render('admin/amenagement.html.twig', [
            'amenagements' => $amenagements,
        ]);
    }

    /**
     * @Route("/admin/amenagement/create", name="admin_amenagement_create")
     */
    public function create(Request $request): Response
    {
        $amenagement = new Amenagement();
        $form = $this->createForm(AmenagementType::class, $amenagement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($amenagement);
            $manager->flush();

            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_amenagement');


        }

        return $this->render('admin/amenagementForm.html.twig', [
            'amenagementForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/amenagement/update/{id}", name="admin_amenagement_update")
     */
    public function update(Request $request, AmenagementRepository $amenagementRepository,$id ): Response
    {
        $amenagement = $amenagementRepository->find($id);
        $form = $this->createForm(AmenagementType::class, $amenagement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($amenagement); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_amenagement');
        }
        
        return $this->render('admin/amenagementForm.html.twig', [
            'amenagementForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/amenagement/delete/{id}", name="admin_amenagement_delete")
     */
    public function delete(AmenagementRepository $amenagementRepository,$id ): Response
    {
        $amenagement = $amenagementRepository->find($id);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($amenagement); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été supprimée');

            return $this->redirectToRoute('admin_amenagement');
        
    }
}
