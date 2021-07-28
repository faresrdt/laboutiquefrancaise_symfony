<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Merci de nous avoir contacter. Notre équipe va vour répondre dans les meilleurs délais.');

            //Envoyer la demande de contact à l'adresse mail de l'admin ou de la personne qui gère les demandes de contact
            // $mail = new Mail();
            // $mail->send('sav@laboutiquefrancaise.com', 'La Boutique Française', 'Vous avez reçu une nouvelle demande de contact', 'contenu du formulaire');
            // RAPPEL : les data du formulaire se récupère avec $form->getData();
            // Faire un dd($form->getData()); pour voir les data et construire le contenu du mail à envoyer
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}