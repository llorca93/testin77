<?php

namespace App\Controller;

use App\Entity\Assainissement;
use App\Form\AssainissementType;
use App\Repository\AssainissementRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AssainissementController extends AbstractController
{
    /**
    *@Route("/admin/assainissement", name="admin_assainissement")
    */
    public function index(AssainissementRepository $assainissementRepository): Response
    {
        $assainissements = $assainissementRepository->findAll();
        return $this->render('admin/assainissement.html.twig', [
            'assainissements' => $assainissements
        ]);
    }

    /**
    *@Route("/admin/assainissement/create", name="admin_assainissement_create")
    */
    public function createAssainissement(Request $request, SluggerInterface $slugger): Response
    {
        $assainissement = new Assainissement();
        $form = $this->createForm(AssainissementType::class, $assainissement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $file = $form->get('file')->getData();

            if($file){
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName. '-'.uniqid(). '.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('travaux_directory'),
                        $newFileName
                    );
                } catch (FileException $e) {

                }

                $assainissement->setFile($newFileName);
            }


            $manager = $this->getDoctrine()->getManager();
            $manager->persist($assainissement); 
            $manager->flush(); 
            $this->addFlash('success','La compétence a bien été ajoutée');

            return $this->redirectToRoute('admin_assainissement');
        }

        return $this->render('admin/assainissementForm.html.twig', [
            'assainForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/assainissement/modifier/{id}", name="admin_assainissement_update")
     */
    public function updateAssainissement(Request $request,AssainissementRepository $assainissementRepository, $id)
    {
        $assainissement = $assainissementRepository->find($id);
        $form = $this->createForm(AssainissementType::class, $assainissement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $infoFile = $form['file']->getData();
            $nomOldFile = $assainissement->getFile();
            if($infoFile !== null){

                $cheminFile = $this->getParameter('travaux_directory') . '/' . $nomOldFile;

                if(file_exists($cheminFile)){
                    unlink($cheminFile);
                }
                $extensionFile = $infoFile->guessExtension();
                $nomFile = time() . '-1.' . $extensionFile;
                $infoFile->move($this->getParameter('travaux_directory'), $nomFile);
                $assainissement->setFile($nomFile);
            }else{
                $assainissement->setFile($nomOldFile);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($assainissement);
            $manager->flush();
            $this->addFlash('success','La compétence a bien été modifiée');
            return $this->redirectToRoute('admin_assainissement');
        }

        return $this->render('admin/assainissementForm.html.twig', [
            'assainForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/assainissement/delete/{id}", name="admin_assainissement_delete")
     */
    public function deleteAssainissement(AssainissementRepository $assainissementRepository, $id)
    {
        $assainissement = $assainissementRepository->find($id);

        $nomFile = $assainissement->getFile();
        if($nomFile !== null){
            $cheminFile = $this->getParameter('travaux_directory') . '/' . $nomFile;
            if(file_exists($cheminFile)){
                unlink($cheminFile);
            }
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($assainissement);
        $manager->flush();
        $this->addFlash('success','La compétence a bien été supprimée');

        return $this->redirectToRoute('admin_assainissement');

    }
}
