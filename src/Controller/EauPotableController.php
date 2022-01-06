<?php

namespace App\Controller;

use App\Form\EauType;
use App\Entity\EauPotable;
use App\Repository\EauPotableRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EauPotableController extends AbstractController
{
    /**
     * @Route("/admin/eau-potable", name="admin_eau")
     */
    public function index(EauPotableRepository $eauRepository): Response
    {
        $eaux = $eauRepository->findAll();

        return $this->render('admin/eau.html.twig', [
            'eaux' => $eaux
        ]);
    }

    /**
     * @Route("/admin/eau-potable/create", name="admin_eau_create")
     */
    public function create(Request $request): Response
    {
        $eau = new EauPotable();
        $form = $this->createForm(EauType::class, $eau);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($eau); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_eau');
        }

        return $this->render('admin/eauForm.html.twig', [
            'eauForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/eau-potable/update/{id}", name="admin_eau_update")
     */
    public function update(Request $request, EauPotableRepository $eauRepository,$id ): Response
    {
        $eau = $eauRepository->find($id);
        $form = $this->createForm(EauType::class, $eau);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($eau); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_eau');
        }
        
        return $this->render('admin/eauForm.html.twig', [
            'eauForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/eau-potable/delete/{id}", name="admin_eau_delete")
     */
    public function delete(EauPotableRepository $eauRepository,$id ): Response
    {
        $eau = $eauRepository->find($id);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($eau); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été supprimée');

            return $this->redirectToRoute('admin_eau');
        
    }
}
