<?php

namespace App\Controller;

use App\Repository\HydrologieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HydrologiesController extends AbstractController
{
    /**
     * @Route("/hydrologie-hydraulique", name="hydrologies")
     */
    public function index(HydrologieRepository $hydrologieRepository): Response
    {
        $hydrologies = $hydrologieRepository->findAll();

        return $this->render('hydrologies/index.html.twig', [
            'hydrologies' => $hydrologies,
        ]);
    }
}
