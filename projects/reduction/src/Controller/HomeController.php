<?php

namespace App\Controller;

use App\Form\ReductionType;
use App\Service\ReductionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/accueil", name="home")
     */
    public function index(Request $request, ReductionService $david): Response
    {
        $formulaire = $this->createForm(ReductionType::class);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted()) {
            $data = $formulaire->getData();
            $nom = $data['nomProduit'];
            $prix = $data['prixInitial'];
            $percent = $data['pourcentageReduction'];

            $final = $david->calculer($prix, $percent);

            return $this->render('home/success.html.twig', [
                'produit' => $nom,
                'initial' => $prix,
                'percent' => $percent,
                'final' => $final
            ]);
        } else {
            return $this->renderForm('home/index.html.twig', [
                'formi' => $formulaire
            ]);
        }
    }
}
