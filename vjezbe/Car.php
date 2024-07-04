<?php

// declare(strict_types=1); 
//ovo bi znacilo da ako smo npr. deklarirali da weight mora biti string, ne mozemo upisati int; bez ovog ce php automatski pretvorit int u string

Class Car {

    private string $make;
    private string $model;
    private string $fuel;
    private int $weight;

    private function belongsTo()
    {

    }

    public function getFullName() : string
    {
        return "$this->make - $this->model";
    }

    // getter metoda - vraca vrijednost privatnog svojstva izvan klase
    public function getMake(): string
    {
        return $this->make;
    }

    // setter metoda - sluzi za postavljanje vrijednosti privatnog svojstva izvan klase
    public function setMake(string $make)
    {
        $this->make = $make;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model)
    {
        $this->model = $model;
        return $this;
    }

    public function getFuel(): string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel)
    {
        $this->fuel = $fuel;
        return $this;
    }

    public function getWeight() : int
    {
        return $this->weight;
    }

    public function setWeight(int $weight)
    {
        $this->weight = $weight;
        return $this;
    }

    public function toArray()
    {
        return [
            'make' => $this->make,
            'model' => $this->model,
            'fuel' => $this->fuel,
            'weight' => $this->weight
        ];
    }
}

$teslaS = new Car();

$teslaS->setMake('Tesla');
$teslaS->setModel('Model S');
$teslaS->setFuel('electric');
$teslaS->setWeight(2300);

//ili ovako, moguce zbog "return $this" u svim setter metodama, jer se svaka strelica onda nadovezuje na objekt (vraceni $this):
/*
$teslaS
    ->setMake('Tesla')
    ->setModel('Model S')
    ->setFuel('electric')
    ->setWeight(2300);
*/

echo $teslaS->getFullName();
