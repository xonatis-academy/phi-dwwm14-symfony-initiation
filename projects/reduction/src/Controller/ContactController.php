<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        $contact = $this->createForm(ContactType::class);
        $contact->handleRequest($request);

        if ($contact->isSubmitted()) {
            $donnees = $contact->getData();
            $email = $donnees['email'];           

            return $this->render('contact/success.html.twig', [
                'email' => $email
            ]);
        } else {
            return $this->renderForm('contact/index.html.twig', [
                'formulaire' => $contact
            ]);
        }
    }
}
