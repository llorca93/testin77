<?php

namespace App\Controller;

use App\Repository\VoirieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoiriesController extends AbstractController
{
    /**
     * @Route("/voiries-et-reseaux-divers", name="voiries")
     */
    public function index(VoirieRepository $voirieRepository): Response
    {
        $voiries = $voirieRepository->findAll();
        return $this->render('voiries/index.html.twig', [
            'voiries' => $voiries,
        ]);
    }
}
