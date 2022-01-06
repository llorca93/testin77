<?php

namespace App\Controller;

use App\Repository\SocieteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SocieteController extends AbstractController
{
    /**
    *@Route("/societe", name="societe")
    */
    public function index(SocieteRepository $societeRepository): Response
    {
        $societes = $societeRepository->findAll();
        return $this->render('societe/index.html.twig', [
            'societes' => $societes,
        ]);
    }
}
