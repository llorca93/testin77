<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SliderController extends AbstractController
{
    /**
     * @Route("/admin/slider", name="admin_slider")
     */
    public function index(SliderRepository $sliderRepository): Response
    {
        $slides = $sliderRepository->findAll();

        return $this->render('admin/slider.html.twig', [
            'slides' => $slides,
        ]);
    }

    /**
     * @Route("/admin/slider/create", name="admin_slider_create")
     */
    public function create(Request $request)
    {
        $slide = new Slider();
        $form = $this->createForm(SliderType::class, $slide);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $slide->setActive(false);

                $infoIllustration = $form['illustration']->getData();
                $nomOldIllustration = $slide->getIllustration();

                if($infoIllustration !== null){

                    $cheminIllustration = $this->getParameter('slider_directory') . '/' . $nomOldIllustration;

                    $extensionIllustration = $infoIllustration->guessExtension();
                    $nomIllustration = time() . '-1.' . $extensionIllustration;
                    $infoIllustration->move($this->getParameter('slider_directory'), $nomIllustration);
                    $slide->setIllustration($nomIllustration);
                } else {
                    $slide->setIllustration($nomOldIllustration);
                }

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($slide);
                $manager->flush();
                $this->addFlash('success', 'Le slide a bien été ajouté');
                return $this->redirectToRoute('admin_slider');
            } else {
                $this->addFlash('erreur', 'Une erreur est survenue lors de l\'ajout du slide');
            }

        }

        return $this->render('admin/sliderForm.html.twig', [
            'sliderForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/slider/activer/{id}", name="admin_slider_activer")
     */
    public function activer(SliderRepository $sliderRepository, $id)
    {
        $slide = $sliderRepository->find($id);
        $slide->setActive(($slide->getActive()) ? false : true);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($slide);
        $manager->flush();

        return new Response('true');
    }

    /**
     * @Route("/admin/slider/update/{id}", name="admin_slider_update")
     */
    public function update(SliderRepository $sliderRepository, $id, Request $request)
    {
        $slide = $sliderRepository->find($id);
        $form = $this->createForm(SliderType::class, $slide);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $infoIllustration = $form['illustration']->getData();
            $nomOldIllustration = $slide->getIllustration();

            if($infoIllustration !== null){

                $cheminIllustration = $this->getParameter('slider_directory') . '/' . $nomOldIllustration;

                if(file_exists($cheminIllustration)){
                    unlink($cheminIllustration);
                }
                $extensionIllustration = $infoIllustration->guessExtension();
                $nomIllustration = time() . '-1.' . $extensionIllustration;
                $infoIllustration->move($this->getParameter('slider_directory'), $nomIllustration);
                $slide->setIllustration($nomIllustration);
            } else {
                $slide->setIllustration($nomOldIllustration);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($slide);
            $manager->flush();
            $this->addFlash('success','Le slide a bien été modifié');
            return $this->redirectToRoute('admin_slider');
        }

        return $this->render('admin/sliderForm.html.twig', [
            'sliderForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/slider/delete/{id}", name="admin_slider_delete")
     */
    public function delete(SliderRepository $sliderRepository, $id)
    {
        $slide = $sliderRepository->find($id);

        $nomIllustration = $slide->getIllustration();
        if($nomIllustration !== null){
            $cheminIllustration = $this->getParameter('slider_directory') . '/' . $nomIllustration;
            if(file_exists($cheminIllustration)){
                unlink($cheminIllustration);
            }
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($slide);
        $manager->flush();
        $this->addFlash('success','Le slide a bien été supprimé');

        return $this->redirectToRoute('admin_slider');
    }
}
