<?php

namespace App\Controller;

use App\Entity\Organisation;
use App\Form\OrganisationType;
use App\Repository\OrganisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrganisationController extends AbstractController
{
    /**
     * @Route("/admin/organisation", name="admin_organisation")
     */
    public function index(OrganisationRepository $organisationRepository): Response
    {
        $postes = $organisationRepository->findAll();

        return $this->render('admin/organisation.html.twig', [
            'postes' => $postes,
        ]);
    }

    /**
     * @Route("/admin/organisation/create", name="admin_organisation_create")
     */
    public function create(Request $request)
    {
        $poste = new Organisation();
        $form = $this->createForm(OrganisationType::class, $poste);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($poste);
            $manager->flush();
            $this->addFlash('message', 'Le poste a bien été créé');

            return $this->redirectToRoute('admin_organisation');
        }

        return $this->render('admin/organisationForm.html.twig', [
            'organisationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/organisation/update/{id}", name="admin_organisation_update")
     */
    public function update(Request $request, OrganisationRepository $organisationRepository, $id)
    {
        $poste = $organisationRepository->find($id);
        $form = $this->createForm(OrganisationType::class, $poste);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($poste);
            $manager->flush();
            $this->addFlash('message', 'Le poste a bien été mis à jour');

            return $this->redirectToRoute('admin_organisation');
        }

        return $this->render('admin/organisationForm.html.twig', [
            'organisationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/organisation/delete/{id}", name="admin_organisation_delete")
     */
    public function delete(OrganisationRepository $organisationRepository, $id)
    {
        $poste = $organisationRepository->find($id);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($poste);
            $manager->flush();
            $this->addFlash('message', 'Le poste a bien été supprimé');

            return $this->redirectToRoute('admin_organisation');
        
    }
}
