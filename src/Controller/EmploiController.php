<?php

namespace App\Controller;

use App\Entity\Emplois;
use App\Form\EmploisType;
use App\Repository\EmploisRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmploiController extends AbstractController
{
    /**
     * @Route("/admin/emploi", name="admin_emploi")
     */
    public function index(EmploisRepository $emploisRepository): Response
    {
        $emplois = $emploisRepository->findAll();

        return $this->render('admin/emplois.html.twig', [
            'emplois' => $emplois,
        ]);
    }

    /**
     * @Route("/admin/emploi/create", name="admin_emploi_create")
     */
    public function create(Request $request)
    {
        $emploi = new Emplois();
        $form = $this->createForm(EmploisType::class, $emploi);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $emploi->setActive(false);
            
                $infoFile = $form['file']->getData();
                $nomOldFile = $emploi->getFile();
                if($infoFile !== null){

                    $cheminFile = $this->getParameter('emploi_directory') . '/' . $nomOldFile;
                    $extensionFile = $infoFile->guessExtension();
                    $nomFile = time() . '-1.' . $extensionFile;
                    $infoFile->move($this->getParameter('emploi_directory'), $nomFile);
                    $emploi->setFile($nomFile); 
                } else {
                    $emploi->setFile($nomOldFile);
                }

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($emploi);
                $manager->flush();
                $this->addFlash('success', 'L\'offre d\'emploi a bien été ajoutée');
                return $this->redirectToRoute('admin_emploi');
            } else {
                $this->addFlash('erreur', 'Une erreur est survenue lors de l\'ajout de l\'offre d\'emploi');
            }
        }

        return $this->render('admin/emploiForm.html.twig', [
            'emploiForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/emploi/update/{id}", name="admin_emploi_update")
     */
    public function update(EmploisRepository $emploisRepository, $id, Request $request)
    {
        $emploi = $emploisRepository->find($id);
        $form = $this->createForm(EmploisType::class, $emploi);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $infoFile = $form['file']->getData();
            $nomOldFile = $emploi->getFile();

            if($infoFile !== null){

                $cheminFile = $this->getParameter('emploi_directory') . '/' . $nomOldFile;

                if(file_exists($cheminFile)){
                    unlink($cheminFile);
                }
                $extensionFile = $infoFile->guessExtension();
                $nomFile = time() . '-1.' . $extensionFile;
                $infoFile->move($this->getParameter('emploi_directory'), $nomFile);
                $emploi->setFile($nomFile);
            } else {
                $emploi->setFile($nomOldFile);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($emploi);
            $manager->flush();
            $this->addFlash('success','L\'offre d\'emploi a bien été modifiée');
            return $this->redirectToRoute('admin_emploi');
        }

        return $this->render('admin/emploiForm.html.twig', [
            'emploiForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/emploi/delete/{id}", name="admin_emploi_delete")
     */
    public function delete(EmploisRepository $emploisRepository, $id)
    {
        $emploi = $emploisRepository->find($id);
        $nomFile = $emploi->getFile();

        if($nomFile !== null){
            $cheminFile = $this->getParameter('emploi_directory') . '/' . $nomFile;
            if(file_exists($cheminFile)){
                unlink($cheminFile);
            }
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($emploi);
        $manager->flush();
        $this->addFlash('success', 'L\'offre d\'emploi a bien été supprimée');

        return $this->redirectToRoute('admin_emploi');
    }

    /**
     * @Route("/admin/emploi/activer/{id}", name="admin_emploi_activer")
     */
    public function activer(EmploisRepository $emploisRepository, $id)
    {
        $emploi = $emploisRepository->find($id);
        $emploi->setActive(($emploi->getActive()) ? false : true );

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($emploi);
        $manager->flush();

        return new Response('true');
    }
}
