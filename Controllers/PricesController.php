<?php

namespace Controllers;

use Core\Database;
use Core\Session;
use Core\Validator;
use Core\ResourceInUseException;

class PricesController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id): array
    {
        $sql = "SELECT * FROM cjenik WHERE id = :id";
        return $this->db->query($sql, [
            'id' => $id,
        ])->findOrFail();
    }
    
    private function validateData(array $rules, array $postData): array
    {
        $form = new Validator($rules, $postData);
        if ($form->notValid()) {
            Session::flash('errors', $form->errors());
            Session::flash('old', $form->getData());
            goBack();
        }

        return $form->getData();
    }

    public function index()
    {
        $sql = "SELECT id, 
                    tip_filma AS tip, 
                    cijena, zakasnina_po_danu AS zakasnina 
                FROM cjenik 
                ORDER BY tip";

        $prices = $this->db->query($sql)->all();

        $message = Session::get('message'); 

        $pageTitle = 'Cjenik';

        require basePath('views/prices/index.view.php');
    }
    
    public function show()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $sql = "SELECT f.*, 
                    z.ime AS zanr, 
                    GROUP_CONCAT(DISTINCT m.tip) AS medij, 
                    c.tip_filma AS tip
                FROM filmovi f
                    JOIN cjenik c ON f.cjenik_id = c.id
                    JOIN zanrovi z ON f.zanr_id = z.id
                    LEFT JOIN kopija k ON k.film_id = f.id 
                    LEFT JOIN mediji m ON k.medij_id = m.id
                WHERE c.id = :id
                GROUP BY f.id
                ORDER BY f.naslov";
            
        $price = $this->validateId($_GET['id']);
        $movies = $this->db->query($sql, ['id' => $_GET['id'],])->all();
        
        foreach ($movies as $key => $movie) {
            $movies[$key]['medij'] = explode(',', $movie['medij']);
        }
        
        $pageTitle = 'Tip filma';
        
        require basePath('views/prices/show.view.php');
    }
    
    public function edit()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $price = $this->validateId($_GET['id']);

        $pageTitle = 'Uredi Tip filma';
        
        $errors = Session::get('errors');   

        require basePath('views/prices/edit.view.php');
    }
    
    public function update()
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $postData = [
            'tip_filma' => $_POST['movie_type'] ?? null,
            'cijena' => $_POST['price'] ?? null,
            'zakasnina_po_danu' => $_POST['late_fee'] ?? null,
        ];

        $rules = [
            'tip_filma' => ['required', 'unique:cjenik,' . $_POST['id'], 'string', 'max:20', 'min:2'],
            'cijena' => ['required', 'numeric', 'max:10'],
            'zakasnina_po_danu' => ['required', 'numeric', 'max:10'],
        ];

        $data = $this->validateData($rules, $postData);

        $sql = "SELECT * FROM cjenik WHERE id = :id";
        $this->db->query($sql, ['id' => $_POST['id']])->findOrFail();

        $sql = "UPDATE cjenik 
                SET tip_filma = :tip_filma, 
                    cijena = :cijena, 
                    zakasnina_po_danu = :zakasnina_po_danu 
                WHERE id = :id";

        $this->validateId($_POST['id']);

        $this->db->query($sql, [
            'tip_filma' => $data['tip_filma'], 
            'cijena' => $data['cijena'], 
            'zakasnina_po_danu' => $data['zakasnina_po_danu'], 
            'id' => $_POST['id'],
        ]);
        
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o tipu filma {$data['tip_filma']}."
        ]); 
        
        redirect('prices');
    }
    
    public function create()
    {
        $pageTitle = 'Tip filma';

        $errors = Session::get('errors');
        $old = Session::get('old');

        require basePath('views/prices/create.view.php');
    }
    
    public function store()
    {
        $postData = [
            'tip_filma' => $_POST['movie_type'] ?? null,
            'cijena' => $_POST['price'] ?? null,
            'zakasnina_po_danu' => $_POST['late_fee'] ?? null,
        ];

        $rules = [
            'tip_filma' => ['required', 'unique:cjenik', 'string', 'max:20', 'min:2'],
            'cijena' => ['required', 'numeric', 'max:10'],
            'zakasnina_po_danu' => ['required', 'numeric', 'max:10'],
        ];
        
        $data = $this->validateData($rules, $postData);
        
        $sql = "INSERT INTO cjenik (tip_filma, cijena, zakasnina_po_danu) VALUES (:tip_filma, :cijena, :zakasnina_po_danu)";
        
        $this->db->query($sql, [
            'tip_filma' => $data['tip_filma'], 
            'cijena' => $data['cijena'], 
            'zakasnina_po_danu' => $data['zakasnina_po_danu'], 
        ]);
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreiran tip filma {$data['tip_filma']}."
        ]);    
        
        redirect('prices');
    }
    
    public function destroy()
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
            
        $sql = "DELETE FROM cjenik WHERE id = :id";
        
        try {
            $price = $this->validateId($_POST['id']);
        
            $this->db->query($sql, ['id' => $_POST['id']]);
        } catch (ResourceInUseException $e) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati tip filma {$price['tip_filma']} prije nego obrišete film tog tipa."
            ]);
            goBack();
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisan tip filma {$price['tip_filma']}."
        ]);

        redirect('prices');
    } 
}