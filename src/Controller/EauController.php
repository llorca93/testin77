<?php

namespace App\Controller;

use App\Repository\EauPotableRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EauController extends AbstractController
{
    /**
     * @Route("/eau-potable", name="eau")
     */
    public function index(EauPotableRepository $eauRepository): Response
    {
        $eaux = $eauRepository->findAll();
        return $this->render('eau/index.html.twig', [
            'eaux' => $eaux,
        ]);
    }
}
