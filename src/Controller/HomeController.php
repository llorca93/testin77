<?php

namespace App\Controller;

use App\Repository\SliderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
    *@Route("/", name="home")
    */
    public function index(SliderRepository $sliderRepository): Response
    {
        $slides = $sliderRepository->findBy(['active' => true], ['id' => 'ASC'], 17);
        

        return $this->render('home/index.html.twig', [
            'slides' => $slides,
        ]);
    }
}
