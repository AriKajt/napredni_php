<?php

include "Car.php";

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

class Vlasnik {

    private string $ime;
    private string $prezime;
    private int $godine;
    private string $spol;
    private ?string $adresa; //ovaj property moze biti null ili string, ? znaci da je nullable
    private Car $car;


    public function __construct(string $ime, string $prezime, int $godine, string $spol, ?string $adresa)
    {
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->godine = $godine;
        $this->spol = $spol;
        $this->adresa = $adresa;

        $this->car = new Car();
        $this->car
            ->setMake('Tesla')
            ->setModel('Model S')
            ->setFuel('electric')
            ->setWeight(2300);
    }

    public function posjeduje()
    {
        return $this->car;
    }
    
}

$tena = new Vlasnik('Tena', 'Fiskus', 31, 'Zensko', null);
dd($tena->posjeduje());