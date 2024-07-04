<?php

// OOP -> Object Oriented Programming

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

class Korisnik {

    // svojstva objekta -> properties
    public $ime;
    private $godine;
    public $spol;
    protected $adresa;

    // metode objekta -> methods
    public function posudjujeFilm(){
        // pomocu kljucne rijeci $this pristupamo svojstvima i metodama unutar klase; ovdje svojstvu ime dodjeljujemo vrijednost Alex
        $this->ime = 'Alex';

        // varijabla $godine u ovom slucaju je lokalna unutar metode posudjujeFilm()
        // to nije svojstvo definirano na pocetku klase, to svojstvo moze biti drugacije od 39 kako smo dodijelili vrijednost ovoj varijabli
        $godine = 39;
        
        $this->seUclanjuje();

        echo $this->ime . ' je posudio Film, on ima ' . $godine . ' godina :-D ';
    }
    
    private function seUclanjuje(){
        echo 'Korisnik je uclanjen';
    }
}

$tena = new Korisnik();
$tena->ime = 'Tena';
$tena->spol = 'Zensko';
$tena->posudjujeFilm();

$ari = new Korisnik();
$ari->ime = 'Arian';
$ari->spol = 'Nebinarno';
$ari->posudjujeFilm();

$korisnik = new Korisnik();
$korisnik->ime = 'Aleksandar';
$korisnik->spol = 'Musko';
$korisnik->posudjujeFilm();


// dd($korisnik);