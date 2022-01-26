<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RememberService {

    private $coeur;

    public function __construct(SessionInterface $sessionInterface)
    {
        $this->coeur = $sessionInterface;
    }

    public function seSouvenir(string $nom, string $valeur): void {
        $this->coeur->set($nom, $valeur);
    }

    public function toutOublier():void {
        $this->coeur->clear();
    }

    public function donneMoi(string $nom): ?string {
        return $this->coeur->get($nom);
    }

}