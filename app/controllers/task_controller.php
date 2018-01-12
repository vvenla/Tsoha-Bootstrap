<?php

class TaskController extends BaseController {

    public static function index() {
        $user_logged_in = self::get_user_logged_in();
        $tasks = Task::all(array('user_id' => $user_logged_in->id));
        
        View::make('task/index.html', array('tasks' => $tasks));
    }

    public static function create() {
        $tasks = Task::all();
        View::make('task/new.html', array('tasks' => $tasks));
    }

    public static function store() {
        $user_logged_in = self::get_user_logged_in();
        
        $params = $_POST;
        $attributes = array(
            'name' => trim($params['name']),
            'description' => trim($params['description']),
            'deadline' => $params['deadline']);

        $task = new Task($attributes);

        if ($task->deadline == '') {
            $task->deadline = NULL;
        }

        $errors = $task->errors();
        if (count($errors) == 0) {
            $task->save();

            Redirect::to('/task', array('message' => 'Task added!'));
        } else {
            View::make('/task/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function show($id) {
        $task = Task::find($id);
        View::make('task/show.html', array(
            'name' => $task->name,
            'description' => $task->description,
            'deadline' => $task->deadline));
    }

    public static function edit($id) {
        $task = Task::find($id);
        View::make('task/show.html', array('attributes' => $task));
    }

    public static function upd($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'name' => trim($params['name']),
            'description' => trim($params['description']),
            'deadline' => $params['deadline']
        );

        $task = new Task($attributes);

        if ($task->deadline == '') {
            $task->deadline = NULL;
        }

        $errors = $task->errors();
        if (count($errors) == 0) {
            $task->update();

            Redirect::to('/task', array('message' => 'Task updated!'));
        } else {
            View::make('/task/show.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function del($id) {
        $task = new Task(array('id' => $id));
        $task->delete();

        Redirect::to('/task', array('message' => 'Task deleted!'));
    }

}
