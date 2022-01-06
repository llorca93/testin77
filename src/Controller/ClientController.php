<?php

namespace App\Controller;

use App\Repository\CommunesRepository;
use App\Repository\ClientsCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route("/clients", name="clients")
     */
    public function index(CommunesRepository $communesRepository, ClientsCategoryRepository $clientsCategoryRepository): Response
    {
        $cat1 = $clientsCategoryRepository->findOneBy(['name' => 'communes'], ['id' => 'ASC'],1);
        $cat2 = $clientsCategoryRepository->findOneBy(['name' => 'communautés de communes'], ['id' => 'ASC'],1);
        $cat3 = $clientsCategoryRepository->findOneBy(["name" => "Communauté d’Agglomération"], ['id' => 'ASC']);
        $cat4 = $clientsCategoryRepository->findOneBy(["name" => "Syndicat d’Agglomération Nouvelle"], ['id' => 'ASC']);
        $cat5 = $clientsCategoryRepository->findOneBy(["name" => "Syndicat Intercommunal d’Assainissement"], ['id' => 'ASC']);
        $cat6 = $clientsCategoryRepository->findOneBy(["name" => "Syndicat Intercommunal d’Adduction d’Eau Potable"], ['id' => 'ASC']);
        $cat7 = $clientsCategoryRepository->findOneBy(["name" => "Syndicat Intercommunal d’Eau et d’Assainissement"], ['id' => 'ASC']);
        $cat8 = $clientsCategoryRepository->findOneBy(["name" => "Syndicat Mixte d’Aménagement et d’Entretien"], ['id' => 'ASC']);
        $cat9 = $clientsCategoryRepository->findOneBy(["name" => "Industriels"], ['id' => 'ASC']);
        $cat10 = $clientsCategoryRepository->findOneBy(["name" => "Aménageurs privés"], ['id' => 'ASC']);
        $communes1 = $communesRepository->findByCategory(1);
        $communes2 = $communesRepository->findByCategory(2);
        $communes3 = $communesRepository->findByCategory(3);
        $communes4 = $communesRepository->findByCategory(4);
        $communes5 = $communesRepository->findByCategory(5);
        $communes6 = $communesRepository->findByCategory(7);
        $communes7 = $communesRepository->findByCategory(8);
        $communes8 = $communesRepository->findByCategory(9);
        $communes9 = $communesRepository->findByCategory(10);
        $communes10 = $communesRepository->findByCategory(11);
        $communes11 = $communesRepository->findByCategory(12);

        return $this->render('client/index.html.twig', [
            'cat1' => $cat1,
            'cat2' => $cat2,
            'cat3' => $cat3,
            'cat4' => $cat4,
            'cat5' => $cat5,
            'cat6' => $cat6,
            'cat7' => $cat7,
            'cat8' => $cat8,
            'cat9' => $cat9,
            'cat10' => $cat10,
            'communes1' => $communes1,
            'communes2' => $communes2,
            'communes3' => $communes3,
            'communes4' => $communes4,
            'communes5' => $communes5,
            'communes6' => $communes6,
            'communes7' => $communes7,
            'communes8' => $communes8,
            'communes9' => $communes9,
            'communes10' => $communes10,
            'communes11' => $communes11,
        ]);
    }
}
