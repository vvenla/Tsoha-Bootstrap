<?php

class Category extends BaseModel {

    public $id, $personid, $name;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

//    // Palauttaa kaikki kategorioiat
//    public static function all() {
//        $query = DB::connection()->prepare('SELECT * FROM Category');
//        $query->execute();
//        $rows = $query->fetchAll();
//        $categories = array();
//
//        foreach ($rows as $row) {
//            $categories[] = new Category(array(
//                'id' => $row['id'],
//                'personid' => $row['personid'],
//                'name' => $row['name']
//            ));
//        }
//        return $categories;
//    }

    // Palauttaa kaikki käyttäjään liitetyt kategorioiat
    public static function all($user_id) {
        $query = DB::connection()->prepare('SELECT * FROM Category, User '
                . 'WHERE category.personid = :id');
        $query->execute(array('id' => $user_id));
        $rows = $query->fetchAll();
        $categories = array();

        foreach ($rows as $row) {
            $categories[] = new Category(array(
                'id' => $row['id'],
                'personid' => $row['personid'],
                'name' => $row['name']
            ));
        }
        return $categories;
    }

    // Etsii ja palauttaa yhden tietyn kategorian
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Category WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $category = new Category(array(
                'id' => $row['id'],
                'personid' => $row['personid'],
                'name' => $row['name']
            ));
            return $category;
        }
        return null;
    }

    // Tallentaa uuden kategorian tietokantaan
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Category (personid, name) '
                . 'VALUES (:personid, :name) RETURNING id');
        $query->execute(array(
            'name' => $this->name,
            'personid' => $this->personid
        ));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    // Muuttaa kategorian tietoja
    public function update() {
        $query = DB::connection()->prepare('UPDATE Category SET '
                . 'name = :name '
                . 'WHERE id = :id');

        $query->execute(array(
            'id' => $this->id,
            'name' => $this->name
        ));

        $query->fetch();
    }

    // Poistaa kategorian tietokannasta
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Category WHERE id = :id');
        //Kategorian poistamisen voisi estää, jos siellä on tehtäviä
        $query->execute(array('id' => $this->id));
    }

    // Tarkistaa, ettei kategorian nimi ole tyhjä tai liian pitkä
    public function validate_name() {
        $errors = array();
        if ($this->name == NULL) {
            $errors[] = 'Name can not be empty';
        } else if (strlen($this->name) > 30) {
            $errors[] = 'Too long name';
        }
        return $errors;
    }

    // Tarkistaa, onko kategoria liitetty tiettyyn käyttäjään
    public function is_owned_by($user_id) {
        $query = DB::connection()->prepare('SELECT * FROM Person, Category '
                . 'WHERE category.id = :id '
                . 'AND category.personid = :personid LIMIT 1');

        $query->execute(array('id' => $this->id, 'personid' => $user_id));
        $row = $query->fetch();

        if ($row) {
            return TRUE;
        }
        return FALSE;
    }

    // Tarkistaa, onko kategoria tyhjä tehtävistä.
    public function is_empty() {
        $query = DB::connection()->prepare('SELECT * FROM Category, Task '
                . 'WHERE task.categoryid = :id');

        $query->execute(array('id' => $this->id));
        $row = $query->fetch();

        if (!$row) {
            return TRUE;
        }
        return FALSE;
    }

}
