<?php

namespace App\Controller;

use App\Entity\Communes;
use App\Form\CommunesType;
use App\Repository\CommunesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommunesController extends AbstractController
{
    /**
     * @Route("/admin/clients/communes", name="admin_clients_communes")
     */
    public function index(CommunesRepository $communesRepository): Response
    {
        $communes = $communesRepository->findAll();

        return $this->render('admin/communes.html.twig', [
            'communes' => $communes,
        ]);
    }

    /**
     * @Route("/admin/clients/communes/create", name="admin_clients_communes_create")
     */
    public function create(Request $request): Response
    {
        $commune = new Communes();
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commune);
            $manager->flush();
            $this->addFlash('message', 'Le client a bien été ajouté');

            return $this->redirectToRoute('admin_clients_communes');
        }

        return $this->render('admin/communesForm.html.twig', [
            'communesForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/clients/communes/update/{id}", name="admin_clients_communes_update")
     */
    public function update(Request $request, CommunesRepository $communesRepository, $id): Response
    {
        $commune = $communesRepository->find($id);
        $form = $this->createForm(CommunesType::class, $commune);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commune);
            $manager->flush();
            $this->addFlash('message', 'Le client a bien été modifié');

            return $this->redirectToRoute('admin_clients_communes');
        }

        return $this->render('admin/communesForm.html.twig', [
            'communesForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/clients/communes/delete/{id}", name="admin_clients_communes_delete")
     */
    public function delete(CommunesRepository $communesRepository, $id): Response
    {
        $commune = $communesRepository->find($id);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($commune);
            $manager->flush();
            $this->addFlash('message', 'Le client a bien été supprimé');

            return $this->redirectToRoute('admin_clients_communes');
        
    }


}
