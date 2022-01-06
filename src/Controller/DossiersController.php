<?php

namespace App\Controller;

use App\Form\DossiersType;
use App\Entity\DossiersReglementaires;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DossiersReglementairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DossiersController extends AbstractController
{
    /**
     * @Route("/admin/dossiers-reglementaires", name="admin_dossiers")
     */
    public function index(DossiersReglementairesRepository $dossiersRepository): Response
    {
        $dossiers = $dossiersRepository->findAll();
        return $this->render('admin/dossiers.html.twig', [
            'dossiers' => $dossiers
        ]);
    }

    /**
     * @Route("/admin/dossiers-reglementaires/create", name="admin_dossiers_create")
     */
    public function create(Request $request): Response
    {
        $dossier = new DossiersReglementaires();
        $form = $this->createForm(DossiersType::class, $dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($dossier); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_dossiers');
        }
        
        return $this->render('admin/dossiersForm.html.twig', [
            'dossierForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/dossiers-reglementaires/update/{id}", name="admin_dossiers_update")
     */
    public function update(Request $request, DossiersReglementairesRepository $dossiersRepository,$id ): Response
    {
        $dossier = $dossiersRepository->find($id);
        $form = $this->createForm(DossiersType::class, $dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($dossier); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_dossiers');
        }
        
        return $this->render('admin/dossiersForm.html.twig', [
            'dossierForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/dossiers-reglementaires/delete/{id}", name="admin_dossiers_delete")
     */
    public function delete(DossiersReglementairesRepository $dossiersRepository,$id ): Response
    {
        $dossier = $dossiersRepository->find($id);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($dossier); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été supprimée');

            return $this->redirectToRoute('admin_dossiers');
        
    }
}
