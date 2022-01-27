<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class RememberService {

    private $coeur;

    public function __construct(RequestStack $requestStack)
    {
        $this->coeur = $requestStack->getSession();
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