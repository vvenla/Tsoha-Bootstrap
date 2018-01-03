<?php

class Task extends BaseModel{
    public $id, $categoryid, $name, $description, $deadline;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Task');
        $query->execute();
        $rows = $query->fetchAll();
        $tasks = array();
        
        foreach ($rows as $row){
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
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT*FROM Task WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $task = new Task(array(
                'id' => $row['id'],
                'categoryid' => $row['categoryid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'deadline' => $row['deadline']
            ));
            return $task;
        }
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Task'
                . '(categoryid, name, description, deadline)'
                . 'VALUES (NULL, :name, :description, :deadline) RETURNING id');
        $query->execute(array(
            'name'=> $this->name,
            'description'=> $this->description,
            'deadline'=> $this->deadline
        ));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
}

