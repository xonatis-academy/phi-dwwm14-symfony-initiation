<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EmailService $david): Response
    {
        $contact = $this->createForm(ContactType::class, [
            'email' => 'michael@xonatis.com'
        ]);
        $contact->handleRequest($request);

        if ($contact->isSubmitted()) {
            $donnees = $contact->getData();
            $visiteur = $donnees['email'];
            $administrateur = 'admin@mon-super-site.com';
            $subject = $donnees['objet'];
            $message = $donnees['message'];

            // 1. Le mail de contact du visiteur -> administrateur
            $david->envoyer($visiteur, $administrateur, $subject, 'emails/contact.html.twig', [
                'message' => $message
            ]);
            // 2. Le mail d'accusé de reception de l'administrateur -> visiteur
            $david->envoyer($administrateur, $visiteur, "RE: " . $subject, 'emails/accuse.html.twig', [
                'visiteur' => $visiteur
            ]);

            return $this->render('contact/success.html.twig', [
                'email' => $visiteur
            ]);
        } else {
            return $this->renderForm('contact/index.html.twig', [
                'formulaire' => $contact
            ]);
        }
    }
}
