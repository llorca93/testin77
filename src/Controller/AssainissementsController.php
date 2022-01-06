<?php

namespace App\Controller;

use App\Repository\AssainissementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AssainissementsController extends AbstractController
{
    /**
    *@Route("/assainissements", name="assainissements")
    */
    public function index(AssainissementRepository $assainissementRepository): Response
    {
        $assainissements = $assainissementRepository->findByCategory(1);
        return $this->render('assainissements/index.html.twig', [
            'assainissements' => $assainissements,         
        ]);
    }

    /**
    *@Route("/assainissements/domaine-prive", name="assainissements_prive")
    */
    public function prive(AssainissementRepository $assainissementRepository): Response
    {
        $assainissements = $assainissementRepository->findByCategory(2);
        return $this->render('assainissements/domainePrive.html.twig', [
            'assainissements' => $assainissements,         
        ]);
    }

    
}
