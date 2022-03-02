<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            

            $this->addFlash('notice', 'Merci de nous avoir contacté, notre équipe va vous répondre dans les meilleurs délais.');


            $mail = new Mail();
            $content = "Bonjour, <br>Vous avez reçu une nouvelle demande de contact.<br><br>";
            $content .= "Nom du client : ".$form->get('nom')->getData(). "<br>Prénom du client : ".$form->get('prenom')->getData(). "<br>Email du client : ".$form->get('email')->getData(). "<br>";
            $content .= "Contenu du message : ".$form->get('content')->getData(). "<br><br>";
            $mail->send('p.llorca.pl@gmail.com','Test Ingénierie', 'Demande de contact', $content);

            return $this->redirectToRoute('contact');

            
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
