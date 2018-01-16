<?php

class Task extends BaseModel {

    public $id, $categoryid, $name, $description, $deadline;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_date', 'validate_description');
    }

    // Palauttaa kaikki tehtävät
//    public static function all() {
//        $query = DB::connection()->prepare('SELECT * FROM Task');
//        $query->execute();
//        $rows = $query->fetchAll();
//        $tasks = array();
//
//        foreach ($rows as $row) {
//            $tasks[] = new Task(array(
//                'id' => $row['id'],
//                'categoryid' => $row['categoryid'],
//                'name' => $row['name'],
//                'description' => $row['description'],
//                'deadline' => $row['deadline']
//            ));
//        }
//        return $tasks;
//    }

    // Palauttaa kaikki tietyn käyttäjän tehtävät
    public static function all_users_tasks($user_id) {
        $query = DB::connection()->prepare('SELECT * FROM Task, PersonTask '
                . 'WHERE persontask.personid = :user_id');
        $query->execute(array('user_id' => $user_id));
        $rows = $query->fetchAll();
        $tasks = array();

        foreach ($rows as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'categoryid' => $row['categoryid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'deadline' => $row['deadline']
            ));
        }
        return $tasks;
    }
    
    public static function all_tasks_in_category($user_id, $category_id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Task, PersonTask, Category '
                . 'WHERE persontask.personid = :user_id '
                . 'AND task.categoryid = :category_id');
        $query->execute(array('user_id' => $user_id, 'category_id' => $category_id));
        $rows = $query->fetchAll();
        $tasks = array();

        foreach ($rows as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'categoryid' => $row['categoryid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'deadline' => $row['deadline']
            ));
        }
        return $tasks;
    }

    // Palauttaa tietyn tehtävän
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT*FROM Task WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $task = new Task(array(
                'id' => $row['id'],
                'categoryid' => $row['categoryid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'deadline' => $row['deadline']
            ));
            return $task;
        }
        return NULL;
    }

    // Lisää uuden tehtävän tietokantaan
    public function save($user_id) {
        $query = DB::connection()->prepare('INSERT INTO Task '
                . '(categoryid, name, description, deadline)'
                . 'VALUES (NULL, :name, :description, :deadline) RETURNING id');

        $query->execute(array(
            'name' => $this->name,
            'description' => $this->description,
            'deadline' => $this->deadline
        ));
        
        $row = $query->fetch();

        $this->id = $row['id'];
        
        $query2 = DB::connection()->prepare('INSERT INTO PersonTask '
                . '(taskid, personid) '
                . 'VALUES (:taskid, :personid)');
        
        $query2->execute(array(
            'taskid' => $this->id,
            'personid' => $user_id
        ));
    }

    // Muokkaa tehtävän tietoja tietokannassa
    public function update() {
        $query = DB::connection()->prepare('UPDATE Task SET '
                . 'name = :name, '
                . 'description = :description, '
                . 'deadline = :deadline '
                . 'WHERE id = :id');

        $query->execute(array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'deadline' => $this->deadline
        ));
    }

    // Lisää tehtävän tiettyyn kategoriaan
    public function set_category($category_id) {
        $query = DB::connection()->prepare('UPDATE Task SET categoryid = :category_id '
                . 'WHERE id = :id');
        return $query->execute(array('category_id' => $category_id, 'id' => $this->id));
    }

    // Poistaa tehtävän tietokannasta
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Task WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    // Tarkistaa, että deadline on päivämäärämuotoinen
    public function validate_date() {
        $errors = array();
        if (!(strtotime($this->deadline) || $this->deadline == NULL)) {
            $errors[] = 'Deadline can be empty or a date (yyyy-mm-dd)';
        }
        return $errors;
    }

    // Tarkistaa, että nimi ei ole tyhjä eikä liian pitkä
    public function validate_name() {
        $errors = array();
        if ($this->name == NULL) {
            $errors[] = 'Name can not be empty';
        } else if (strlen($this->name) > 30) {
            $errors[] = 'Too long name';
        }
        return $errors;
    }

    // Tarkistaa, että kuvaus ei ole liian pitkä
    public function validate_description() {
        $errors = array();
        if (strlen($this->description) > 90) {
            $errors[] = 'Too long description';
        }
        return $errors;
    }

}
