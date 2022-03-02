<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\SliderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
    *@Route("/", name="home")
    */
    public function index(SliderRepository $sliderRepository, ArticlesRepository $articlesRepository): Response
    {

        $slides = $sliderRepository->findBy(['active' => true], ['id' => 'ASC']);
        $articles = $articlesRepository->findBy(['active' => true], ['createdAt' => 'DESC'],3);

        return $this->render('home/index.html.twig', [
            'slides' => $slides,
            'articles' => $articles
        ]);
    }
}
