<?php

namespace App\Controller;

use App\Entity\Voirie;
use App\Form\VoirieType;
use App\Repository\VoirieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirieController extends AbstractController
{
    /**
     * @Route("/admin/voirie", name="admin_voirie")
     */
    public function index(VoirieRepository $voirieRepository): Response
    {
        $voiries = $voirieRepository->findAll();
        return $this->render('admin/voirie.html.twig', [
            'voiries' => $voiries,
        ]);
    }

    /**
     * @Route("/admin/voirie/create", name="admin_voirie_create")
     */
    public function create(Request $request): Response
    {
        $voirie = new Voirie();
        $form = $this->createForm(VoirieType::class, $voirie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($voirie);
            $manager->flush();

            $this->addFlash('success', 'La compétence a bien été ajoutée');
            return $this->redirectToRoute('admin_voirie');
        }

        return $this->render('admin/voirieForm.html.twig', [
            'voirieForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/voirie/update/{id}", name="admin_voirie_update")
     */
    public function update(Request $request, VoirieRepository $voirieRepository, $id): Response
    {
        $voirie = $voirieRepository->find($id);
        $form = $this->createForm(VoirieType::class, $voirie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($voirie);
            $manager->flush();

            $this->addFlash('success', 'La compétence a bien été mise à jour');
            return $this->redirectToRoute('admin_voirie');
        }

        return $this->render('admin/voirieForm.html.twig', [
            'voirieForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/voirie/delete/{id}", name="admin_voirie_delete")
     */
    public function delete(VoirieRepository $voirieRepository, $id): Response
    {
        $voirie = $voirieRepository->find($id);
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($voirie);
        $manager->flush();

        $this->addFlash('success', 'La compétence a bien été supprimée');

        return $this->redirectToRoute('admin_voirie');
    }
}
