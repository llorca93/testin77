<?php

namespace App\Controller;

use App\Entity\Hydrologie;
use App\Form\HydrologieType;
use App\Repository\HydrologieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HydrologieController extends AbstractController
{
    /**
     * @Route("/admin/hydrologie", name="admin_hydrologie")
     */
    public function index(HydrologieRepository $hydrologieRepository): Response
    {
        $hydrologies = $hydrologieRepository->findAll();

        return $this->render('admin/hydrologie.html.twig', [
            'hydrologies' => $hydrologies,
        ]);
    }

    
    /**
     * @Route("/admin/hydrologie/create", name="admin_hydrologie_create")
     */
    public function create(Request $request): Response
    {
        $hydrologie = new Hydrologie();
        $form = $this->createForm(HydrologieType::class, $hydrologie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($hydrologie); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_hydrologie');
        }

        return $this->render('admin/hydrologieForm.html.twig', [
            'hydroForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/hydrologie/update/{id}", name="admin_hydrologie_update")
     */
    public function update(Request $request, HydrologieRepository $hydrologieRepository,$id ): Response
    {
        $hydrologie = $hydrologieRepository->find($id);
        $form = $this->createForm(HydrologieType::class, $hydrologie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($hydrologie); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_hydrologie');
        }
        
        return $this->render('admin/hydrologieForm.html.twig', [
            'hydroForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/hydrologie/delete/{id}", name="admin_hydrologie_delete")
     */
    public function delete(HydrologieRepository $hydrologieRepository,$id ): Response
    {
        $hydrologie = $hydrologieRepository->find($id);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($hydrologie); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été supprimée');

            return $this->redirectToRoute('admin_hydrologie');
        
    }
}
