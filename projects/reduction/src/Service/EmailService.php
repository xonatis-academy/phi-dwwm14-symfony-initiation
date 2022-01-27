<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService {

    // PROPRIETE : a pour but de contenir quelque chose (valeur primaire, int, float, string etc. ou bien un objet)
    // Caractéristiques
    private $coeur;

    // CONSTRUCTEUR
    public function __construct(MailerInterface $mailer)
    {
        // On met l'objet MailerInterface (qui s'appelle ici $mailer pour des raisons d'explication)
        // à l'intérieur du "coeur" de l'objet courant (objet en cours de construction, qui est l'objet 
        // EmailService) dénommé $this
        $this->coeur = $mailer;
    }

    // METHODE : a pour but de faire quelque chose (traitement) et retourner un résultat (sauf void)
    // Comportements
    public function envoyer(string $expediteur, string $destinataire, string $objet, string $path, array $variables): void {

        $email = new TemplatedEmail();

        $email->from($expediteur);
        $email->to($destinataire);
        $email->subject($objet);
        $email->htmlTemplate($path);
        $email->context($variables);

        $this->coeur->send($email);

    }
}

/**
 * Pour créer un objet EmailService, il faut un objet MailerInterface
 * Pour créer un objet Armoire, il faut un objet Scie
 * 
 * Pour créer un objet Voiture (dont $habitacle), il faut 5 objets Siege provenant d'une usine, Siauto 
 * on met les objets sièges dans 
 * l'habitable pour ceux qui vont utiliser la voiture après sa construction pour s'assoir.
 * On crée un objet Voiture pour se déplacer.
 * 
 * Pour créer un objet EmailService (dont $coeur), il faut 1 objet MailerInterface 
 * provenant d'un container, de Symfony
 * On met l'objet MailerInterface dans le coeur de l'objet EmailService pour être utilisé après la construction
 * pour envoyer des emails.
 * On crée un objet EmailService pour les controllers pour envoyer des emails.
 */
