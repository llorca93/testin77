<?php

namespace App\Controller;

use DateTime;
use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use App\Repository\CommunesRdvRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RendezVousController extends AbstractController
{
    /**
     * @Route("/admin/rendez-vous", name="rendez_vous")
     */
    public function index(CommunesRdvRepository $communesRdvRepository,CalendarRepository $calendarRepository): Response
    {
        $events = $calendarRepository->findAll();
        
        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'communesRdv' => $event->getCommunesRdv()->getName(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllDay()
            ];
        }

        //dd($rdvs);

        $data = json_encode($rdvs);
        //dd($data);


        return $this->render('admin/rendez_vous.html.twig', compact('data'));
    }

    

    /**
     * @Route("/admin/rendez-vous/liste", name="rendez_vous_liste")
     */
    public function liste(CalendarRepository $calendarRepository): Response
    {
        $calendars = $calendarRepository->findAll();

        return $this->render('admin/rendez_vous_liste.html.twig', [
            'calendars' => $calendars
        ]);
    }

    /**
     * @Route("/admin/rendez-vous/create", name="rendez_vous_create")
     */
    public function create(Request $request): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($calendar);
            $manager->flush();
            $this->addFlash('success','Le rendez-vous a bien été créé');

            return $this->redirectToRoute('rendez_vous_liste');
        }

        return $this->render('admin/rendez_vousform.html.twig',[
            'calendarForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/rendez-vous/update/{id}", name="rendez_vous_update")
     */
    public function update(Request $request, CalendarRepository $calendarRepository, $id): Response
    {
        $calendar = $calendarRepository->find($id);
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($calendar);
            $manager->flush();
            $this->addFlash('success','Le rendez-vous a bien été modifié');

            return $this->redirectToRoute('rendez_vous_liste');

        }

        return $this->render('admin/rendez_vousform.html.twig', [
            'calendarForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/rendez-vous/delete/{id}", name="rendez_vous_delete")
     */
    public function delete(CalendarRepository $calendarRepository, $id): Response
    {
        $calendar = $calendarRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($calendar);
        $manager->flush();
        $this->addFlash('success','Le rendez-vous a bien été supprimé');

        return $this->redirectToRoute('rendez_vous_liste');

        
    }
}
