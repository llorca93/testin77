<?php

namespace App\Controller;

use App\Entity\Moyens;
use App\Form\MoyensType;
use App\Repository\MoyensRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoyensController extends AbstractController
{
    /**
     * @Route("/admin/moyens", name="admin_moyens")
     */
    public function index(MoyensRepository $moyensRepository): Response
    {
        $moyens = $moyensRepository->findAll();

        return $this->render('admin/moyens.html.twig', [
            'moyens' => $moyens,
        ]);
    }

    /**
     * @Route("/admin/moyens/create", name="admin_moyens_create")
     */
    public function create(Request $request): Response
    {
        $moyen = new Moyens();
        $form = $this->createForm(MoyensType::class, $moyen);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $infoImg = $form['image']->getData();
            $nomOldImg = $moyen->getImage();

            if($infoImg !== null){

                $cheminImg = $this->getParameter('moyens_directory') . '/' . $nomOldImg;
                $extensionImg = $infoImg->guessExtension();
                $nomImg = time() . '-1.' . $extensionImg;
                $infoImg->move($this->getParameter('moyens_directory'), $nomImg);
                $moyen->setImage($nomImg);
            } else {
                $moyen->setImage($nomOldImg);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($moyen);
            $manager->flush();
            $this->addFlash('message', 'La page a bien été créée');

            return $this->redirectToRoute('admin_moyens');
        }

        return $this->render('admin/moyensForm.html.twig', [
            'moyensForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/moyens/update/{id}", name="admin_moyens_update")
     */
    public function update(MoyensRepository $moyensRepository, Request $request, $id)
    {
        $moyen = $moyensRepository->find($id);
        $form = $this->createForm(MoyensType::class, $moyen);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $infoImg = $form['image']->getData();
            $nomOldImg = $moyen->getImage();

            if($infoImg !== null){

                $cheminImg = $this->getParameter('moyens_directory') . '/' . $nomOldImg;
                
                if(file_exists($cheminImg)){
                    unlink($cheminImg);
                }
                $extensionImg = $infoImg->guessExtension();
                $nomImg = time() . '-1.' . $extensionImg;
                $infoImg->move($this->getParameter('moyens_directory'), $nomImg);
                $moyen->setImage($nomImg);
            } else {
                $moyen->setImage($nomOldImg);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($moyen);
            $manager->flush();
            $this->addFlash('message', 'La page a bien été mise à jour');

            return $this->redirectToRoute('admin_moyens');

        }

        return $this->render('admin/moyensForm.html.twig', [
            'moyensForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/moyens/delete/{id}", name="admin_moyens_delete")
     */
    public function delete(MoyensRepository $moyensRepository, $id)
    {
        $moyen = $moyensRepository->find($id);
        $nomImg = $moyen->getImage();

        if($nomImg !== null){
            $cheminImg = $this->getParameter('moyens_directory') . '/' . $nomImg;
            if(file_exists($cheminImg)){
                unlink($cheminImg);
            }
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($moyen);
        $manager->flush();
        $this->addFlash('message', 'La page a bien été supprimée');

        return $this->redirectToRoute('admin_moyens');
    }
}
