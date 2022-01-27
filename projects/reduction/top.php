<?php

// => : dictionnaire

$b = [
    'prenom' => 'Michael', 
    'metier' => 'Formateur', 
    'note' => 2
];
$b['metier']; // dedans, il y a Formateur

$a = 3;

$b = ['Michael', 'Formateur', 2];

class Couleur {
    public $nom;
}

class Lunette {
    public $couleur;
    public $propre;
}

class Person {
    public $prenom;
    public $metier;
    public $age;
    public $lunette;
}

$d = new Couleur();
$d->nom = 'Rouge';

$a = new Lunette();
$a->couleur = $d;
$a->propre = true;

$b = new Person();
$b->prenom = 'Michael';
$b->metier = 'Formateur';
$b->age = 3;
$b->lunette = $a;

$a->couleur->nom = 'Bleu';
$b->lunette->couleur->nom; // Bleu


// $prixInitial: 0x3457
// $pourcentage : 0x1112
function calculer(float $prixInitial, float $pourcentage): float {

    return $prixInitial * (100 - $pourcentage) / 100;

}

$prenom = 2.3; // 0x3457
$nombre = 2;  // 0x1112

$a = calculer($prenom, $nombre);

