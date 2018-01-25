<?php

class User extends BaseModel {

    public $id, $username, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'id' => $id,
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $user;
        }
        return NULL;
    }

    // Etsii kaikki muut käyttäjät, joille tehtävää ei ole vielä jaettu
    public static function find_other_users($task_id) {
        $query = DB::connection()->prepare('SELECT Person.* FROM Person '
                . 'WHERE person.id NOT IN '
                . '(SELECT personid FROM persontaskcategory '
                . 'WHERE taskid = :task_id)');
        $query->execute(array('task_id' => $task_id));
        $rows = $query->fetchAll();
        $users = array();

        foreach ($rows as $row) {
            $users[] = new User(array(
                'id' => $row['id'],
                'username' => $row['username']
            ));
        }
        return $users;
    }
    
    // Etsii käyttäjät, joiden kanssa tehtävä on jo jaettu
    public static function find_users_shared($user_id, $task_id) {
        $query = DB::connection()->prepare('SELECT Person.* FROM Person '
                . 'WHERE person.id IN '
                . '(SELECT personid FROM persontaskcategory '
                . 'WHERE taskid = :task_id)'
                . 'AND person.id != :user_id');
        $query->execute(array('user_id' => $user_id, 'task_id' => $task_id));
        $rows = $query->fetchAll();
        $users = array();

        foreach ($rows as $row) {
            $users[] = new User(array(
                'id' => $row['id'],
                'username' => $row['username']
            ));
        }
        return $users;
    }

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE '
                . 'username = :username AND '
                . 'password = :password');
        $query->execute(array(
            'username' => $username,
            'password' => $password));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'username' => $username,
                'password' => $password
            ));
            return $user;
        }
        return NULL;
    }

}
