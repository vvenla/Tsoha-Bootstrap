<?php

class Luokka extends BaseModel{
    public $id, $nimi;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Luokka');
        $query->execute();
        $rows = $query->fetchAll();
        
        foreach ($rows as $row){
            $luokat[] = new Luokka(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
        }
        return $luokat;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row){
            $luokka = new Luokka(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
            return $luokka;
        }
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Luokka (nimi) VALUES (:nimi) RETURNING id');
        $query->execute(array(
            'nimi'=> $this->nimi
        ));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    
}

