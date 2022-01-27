<?php

class Cervelle {

}

class Robot {

    private $cerveau;

    public function __construct(Cervelle $cervelle)
    {
        $this->cerveau = $cervelle;
    }

    public function marcher() {
        // déplacer ses ($this) jambes
        // $this->jambes->deplacer();
    }

}


$obj1 = new Cervelle();
$obj2 = new Robot($obj1);

$obj2->marcher();

$obj3 = new Robot($obj1);
$obj3->marcher();