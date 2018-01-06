<?php

class User extends BaseModel {

    public $id, $username, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_username');
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

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE '
                . 'username = :username AND '
                . 'password = :password');
        $query->execute(array(
            'username' => $username,
            'password' => $password));
        $row = $query->fetch();
        
        if($row) {
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
