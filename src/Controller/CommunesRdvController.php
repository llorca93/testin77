<?php

namespace App\Controller;

use App\Entity\CommunesRdv;
use App\Form\CommunesRdvType;
use App\Repository\CommunesRdvRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommunesRdvController extends AbstractController
{
    /**
     * @Route("/admin/communes_rdv", name="communes_rdv")
     */
    public function index(CommunesRdvRepository $communesRdvRepository): Response
    {
        $communes = $communesRdvRepository->findAll();
        return $this->render('admin/communesRdv.html.twig', [
            'communes' => $communes
        ]);
    }

    /**
     * @Route("/admin/communes_rdv/create", name="communes_rdv_create")
     */
    public function create(Request $request): Response
    {
        $commune = new CommunesRdv();
        $form = $this->createForm(CommunesRdvType::class, $commune);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commune);
            $manager->flush();

            $this->addFlash('success','La commune a bien été créée');

            return $this->redirectToRoute('communes_rdv');
        }
        
        return $this->render('admin/communesRdvForm.html.twig', [
            'communesRdvForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/communes_rdv/update/{id}", name="communes_rdv_update")
     */
    public function update(Request $request, CommunesRdvRepository $communesRdvRepository, $id): Response
    {
        $commune = $communesRdvRepository->find($id);
        $form = $this->createForm(CommunesRdvType::class, $commune);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commune);
            $manager->flush();

            $this->addFlash('success','La commune a bien été modifiée');

            return $this->redirectToRoute('communes_rdv');
        }
        
        return $this->render('admin/communesRdvForm.html.twig', [
            'communesRdvForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/communes_rdv/delete/{id}", name="communes_rdv_delete")
     */
    public function delete(CommunesRdvRepository $communesRdvRepository, $id): Response
    {
        $commune = $communesRdvRepository->find($id);
        
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($commune);
            $manager->flush();

            $this->addFlash('success','La commune a bien été supprimée');

            return $this->redirectToRoute('communes_rdv');
        
    }



}
