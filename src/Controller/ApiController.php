<?php

namespace App\Controller;

use DateTime;
use App\Entity\Calendar;
use App\Entity\CommunesRdv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/admin/rendez-vous/api", name="admin_rendez-vous_api")
     */
    public function index(): Response
    {
        return $this->render('api/rendez-vous.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
    *@Route("/admin/rendez-vous/api/{id}/edit", name="api_event_edit", methods={"PUT"})
    */
    public function majEvent(?Calendar $calendar, Request $request): Response
    {

        // on récupère les données
        $donnees = json_decode($request->getContent());
        

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor) 
            
        ){
            // les données sont completes
            // on initialise un code
            $code = 200;

            // on vérifie si l'id existe
            if(!$calendar){
                // on instancie un rdv
                $calendar = new Calendar;

                // on change le code
                $code = 201;
            }

            // on hydrate l'objet avec nos données
            $calendar->setTitle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new DateTime($donnees->start));
            if($donnees->allDay){
                $calendar->setEnd(new DateTime($donnees->start));
            }else{
                $calendar->setEnd(new DateTime($donnees->end));
            }
            $calendar->setAllDay($donnees->allDay);
            $calendar->setCommunesRdv($calendar->getCommunesRdv($donnees->communesRdv));
            $calendar->setBackgroundColor($donnees->backgroundColor);
            $calendar->setBorderColor($donnees->borderColor);
            $calendar->setTextColor($donnees->textColor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            // on retourne le code
            return new Response('ok', $code);


        }else{
            // les données sont incompletes
            return new Response('Données incomplètes', 404);
        }

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
