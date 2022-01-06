<?php

namespace App\Controller;

use App\Entity\Societe;
use App\Form\SocieteType;
use App\Repository\SocieteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/admin/societe", name="admin_societe")
     */
    public function index(SocieteRepository $societeRepository): Response
    {
        $societes = $societeRepository->findAll();

        return $this->render('admin/societe.html.twig', [
            'societes' => $societes,
        ]);
    }

    /**
     * @Route("/admin/societe/create", name="admin_societe_create")
     */
    public function create(Request $request)
    {
        $societe = new Societe();
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $infoIllustration = $form['illustration']->getData();
            $nomOldIllustration = $societe->getIllustration();
            if($infoIllustration !== null){

                $cheminIllustration = $this->getParameter('societe_directory') . '/' . $nomOldIllustration;
                $extensionIllustration = $infoIllustration->guessExtension();
                $nomIllustration = time() . '-1.' . $extensionIllustration;
                $infoIllustration->move($this->getParameter('societe_directory'), $nomIllustration);
                $societe->setIllustration($nomIllustration);
            } else {
                $societe->setIllustration($nomOldIllustration);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($societe);
            $manager->flush();
            $this->addFlash('message', 'La page a bien été crée');

            return $this->redirectToRoute('admin_societe');
        }

        return $this->render('admin/societeForm.html.twig', [
            'societeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/societe/update/{id}", name="admin_societe_update")
     */
    public function update(Request $request, SocieteRepository $societeRepository, $id)
    {
        $societe = $societeRepository->find($id);
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $infoIllustration = $form['illustration']->getData();
            $nomOldIllustration = $societe->getIllustration();
            if($infoIllustration !== null){

                $cheminIllustration = $this->getParameter('societe_directory') . '/' . $nomOldIllustration;
                if(file_exists($cheminIllustration)){
                    unlink($cheminIllustration);
                }
                $extensionIllustration = $infoIllustration->guessExtension();
                $nomIllustration = time() . '-1.' . $extensionIllustration;
                $infoIllustration->move($this->getParameter('societe_directory'), $nomIllustration);
                $societe->setIllustration($nomIllustration);
            } else {
                $societe->setIllustration($nomOldIllustration);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($societe);
            $manager->flush();
            $this->addFlash('message', 'La page a bien été mise à jour');

            return $this->redirectToRoute('admin_societe');
        }

        return $this->render('admin/societeForm.html.twig', [
            'societeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/societe/delete/{id}", name="admin_societe_delete")
     */
    public function delete(SocieteRepository $societeRepository, $id)
    {
        $societe = $societeRepository->find($id);
        $nomIllustration = $societe->getIllustration();

        if($nomIllustration !== null){
            $cheminIllustration = $this->getParameter('societe_directory') . '/' . $nomIllustration;
            if(file_exists($cheminIllustration)){
                unlink($cheminIllustration);
            }
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($societe);
        $manager->flush();
        $this->addFlash('message', 'La page a bien été supprimée');
        
        return $this->redirectToRoute('admin_societe');
    }
}
