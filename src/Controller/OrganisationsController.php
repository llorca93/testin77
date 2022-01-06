<?php

namespace App\Controller;

use App\Repository\OrganisationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrganisationsController extends AbstractController
{
    /**
     * @Route("/organisation", name="organisation")
     */
    public function index(OrganisationRepository $organisationRepository): Response
    {
        $organisations = $organisationRepository->findAll();
        return $this->render('organisations/index.html.twig', [
            'organisations' => $organisations,
        ]);
    }
}
