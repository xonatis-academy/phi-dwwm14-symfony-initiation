<?php

namespace App\Service;

class ReductionService {

    public function calculer(float $prixInitial, float $pourcentage): float {

        return $prixInitial * (100 - $pourcentage) / 100;

    }

}