<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DossiersReglementairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DossiersReglementairesController extends AbstractController
{
    /**
     * @Route("/dossiers-reglementaires", name="dossiers")
     */
    public function index(DossiersReglementairesRepository $dossiersRepository): Response
    {
        $dossiers = $dossiersRepository->findAll();

        return $this->render('dossiers_reglementaires/index.html.twig', [
            'dossiers' => $dossiers,
        ]);
    }
}
