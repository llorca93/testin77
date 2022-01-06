<?php

namespace App\Controller;

use App\Form\ContactEmploiType;
use App\Repository\EmploisRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
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
    public function detail(EmploisRepository $emploisRepository, $slug, MailerInterface $mailer, Request $request)
    {
        $emploi = $emploisRepository->findOneBy(['slug' => $slug]);

        if(!$emploi){
            throw new NotFoundHttpException('Pas d\'offre trouvée');
        }

        $form = $this->createForm(ContactEmploiType::class);
        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            
           
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('77@testingenierie.fr')
                ->subject('Candidature pour le poste de "' . $emploi->getTitre() . '"')
                ->htmlTemplate('emails/contact_emploi.html.twig')
                ->context([
                    'emploi' => $emploi,
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData(),
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
            return $this->redirectToRoute('emplois_detail', ['slug' => $emploi->getSlug()]);
        }

        
        return $this->render('emplois/detail.html.twig', [
            'emploi' => $emploi,
            'form' => $form->createView()
        ]);
    }
}
