<?php

// Le groupe/repertoire virtuel de la classe dans ce fichier
namespace App\Controller;

// on utilise la classe Bon pour l'utiliser dans le code parce qu'on va gérer des bons en base de données
use App\Entity\Bon;
// on utilise le modèle du formulaire pour la création mais aussi pour l'éditition
use App\Form\BonType;
// on utilise BonRepository pour récupérer la liste et pour afficher le détail d'un Bon
use App\Repository\BonRepository;
// on utilise EntityManager pour ajouter un Bon, modifier un Bon et supprimer un Bon
use Doctrine\ORM\EntityManagerInterface;
// on utilise AbstractController pour les méthodes héritées : par exemple, render, renderForm, createForm etc.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// on utilise Request pour trouver les informations saisies par l'utilisateur
use Symfony\Component\HttpFoundation\Request;
// on utilise Response juste pour "définir" que les fonctions liées aux routes vont retourner une Response
use Symfony\Component\HttpFoundation\Response;
// on utilise Route comme annotation pour rendre accessible une fonction par un client (ex: navigateur)
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/bon")
 */
class AdminBonController extends AbstractController
{
    /**
     * @Route("/", name="admin_bon_index", methods={"GET"})
     */
    public function index(BonRepository $bonRepository): Response
    {
        // Affiche la vue 'admin_bon/index.html.twig' avec une variable TWIG 'bons'
        // qui pointe vers la liste de tous les bons en base de données
        return $this->render('admin_bon/index.html.twig', [
            'bons' => $bonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_bon_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // on instantie en mémoire un espace qui a la structure de Bon et qui est vide
        $bon = new Bon();
        // on crée un formulaire $form à partir du modèle BonType et il devra remplir $bon si des 
        // données ont été envoyées
        $form = $this->createForm(BonType::class, $bon);
        // ca dit au $form d'essayer de récupérer les données saisis par un visiteur dans $request
        $form->handleRequest($request);

        // si le formulaire trouve des données dans $request et si les données ont l'air valides
        if ($form->isSubmitted() && $form->isValid()) {
            // on demande à l'objet $entityManager de sauvegarder $bon en base de données
            $entityManager->persist($bon);
            // on *valide* la demande *une fois pour toute*
            $entityManager->flush();
            // on redirige le navigateur vers la route de nom interne 'admin_bon_index'
            // toute la fonction s'arrete ici car il y a un return
            return $this->redirectToRoute('admin_bon_index');
        }

        // on affiche la vue `admin_bon/new.html.twig` avec 2 variables TWIG : 'bon' et 'form',
        // qui pointent respectivement en PHP vers $bon et $form
        return $this->renderForm('admin_bon/new.html.twig', [
            'bon' => $bon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_bon_show", methods={"GET"})
     */
    public function show(Bon $bon): Response
    {
        // on retourne la vue 'admin_bon/show.html.twig' avec comme variable TWIG 'bon'
        // qui pointe coté PHP vers $bon 
        return $this->render('admin_bon/show.html.twig', [
            'bon' => $bon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_bon_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bon $bon, EntityManagerInterface $entityManager): Response
    {
        // création de du formulaire $form à partir du modele BonType pour remplir $bon
        $form = $this->createForm(BonType::class, $bon);
        // on essaie de récupérer les données saisie par le visiteur dans $request
        $form->handleRequest($request);

        // le formulaire regarde si des données ont été soumises et si les données ont l'air valides
        if ($form->isSubmitted() && $form->isValid()) {
            // on valide les changements une fois pour toute
            $entityManager->flush();
            // on redirige le navigateur vers la route de nom interne admin_bon_index
            // on arrête la fonction comme il y a un return
            return $this->redirectToRoute('admin_bon_index', [], Response::HTTP_SEE_OTHER);
        }

        // on affiche la vue 'admin_bon/edit.html.twig' avec les variables TWIG 'bon' et 'form'
        // qui pointent vers en PHP : $bon et $form
        return $this->renderForm('admin_bon/edit.html.twig', [
            'bon' => $bon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_bon_delete", methods={"POST"})
     */
    public function delete(Request $request, Bon $bon, EntityManagerInterface $entityManager): Response
    {
        // on fait des vérifications de sécurité CSRF pour éviter des usurpations d'identité
        if ($this->isCsrfTokenValid('delete'.$bon->getId(), $request->request->get('_token'))) {
            // on demande à l'$entityManager de supprimer le $bon
            $entityManager->remove($bon);
            // on valide les changements une fois pour toute
            $entityManager->flush();
        }

        // on redirige le navigateur vers la route de nom internet 'admin_bon_index'
        return $this->redirectToRoute('admin_bon_index', [], Response::HTTP_SEE_OTHER);
    }
}
