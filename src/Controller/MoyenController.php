<?php

namespace App\Controller;

use App\Repository\MoyensRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoyenController extends AbstractController
{
    /**
     * @Route("/moyens", name="moyens")
     */
    public function index(MoyensRepository $moyensRepository): Response
    {
        $moyens = $moyensRepository->findAll();
        return $this->render('moyen/index.html.twig', [
            'moyens' => $moyens,
        ]);
    }
}
