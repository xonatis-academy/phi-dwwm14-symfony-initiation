<?php

namespace App\Controller;

use App\Form\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter", name="newsletter")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(NewsletterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $data = $form->getData();

            return $this->render('newsletter/ok.html.twig', [
                'email' => $data['email']
            ]);

        } else {
            return $this->renderForm('newsletter/index.html.twig', [
                'form' => $form
            ]);
        }

        
    }
}
