<?php

namespace App\Controller;

use App\Repository\AmenagementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AmenagementsController extends AbstractController
{
    /**
     * @Route("/amenagement-de-rivieres", name="amenagements")
     */
    public function index(AmenagementRepository $amenagementRepository): Response
    {
        $amenagements = $amenagementRepository->findAll();
        return $this->render('amenagements/index.html.twig', [
            'amenagements' => $amenagements
        ]);
    }
}
