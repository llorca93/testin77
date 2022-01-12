<?php

namespace App\Controller;

use App\Form\ContactEmploiType;
use App\Repository\EmploisRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmploisController extends AbstractController
{
    /**
     * @Route("/emplois", name="emplois")
     */
    public function index(EmploisRepository $emploisRepository): Response
    {
        $emplois = $emploisRepository->findBy(['active' => true], ['createdAt' => 'desc'],5);

        return $this->render('emplois/index.html.twig', [
            'emplois' => $emplois,
        ]);
    }

    /**
     * @Route("/emplois/detail/{slug}", name="emplois_detail")
     */
    public function detail(EmploisRepository $emploisRepository, $slug)
    {
        $emploi = $emploisRepository->findOneBy(['slug' => $slug]);
        
        return $this->render('emplois/detail.html.twig', [
            'emploi' => $emploi,
        ]);
    }
}
