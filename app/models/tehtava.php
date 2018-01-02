<?php

class Tehtava extends BaseModel{
    public $id, $luokkaId, $nimi, $kuvaus, $deadline;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Tehtava');
        $query->execute();
        $rows = $query->fetchAll();
        $tehtavat = array();
        
        foreach ($rows as $row){
            $tehtavat[] = new Tehtava(array(
                'id' => $row['id'],
                'luokkaId' => $row['luokkaId'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['nimi'],
                'deadline' => $row['deadline']
            ));
        }
        return $tehtavat;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT*FROM Tehtava WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $tehtava = new Tehtava(array(
                'id' => $row['id'],
                'luokkaId' => $row['luokkaId'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['nimi'],
                'deadline' => $row['deadline']
            ));
            return $tehtava;
        }
        return null;
    }
}

