<?php

class TaskController extends BaseController {

    public static function index() {
        $tasks = Task::all();
        View::make('task/index.html', array('tasks' => $tasks));
    }

    public static function create() {
        $tasks = Task::all();
        View::make('task/new.html', array('tasks' => $tasks));
    }

    public static function store() {
        $params = $_POST;
        $task = new Task(array(
            'name' => $params['name'],
            'description' => $params['description'],
            'deadline' => $params['deadline'],
        ));


        $task->save();
        Redirect::to('/task/' . $task->id, array('message' => 'Task added!'));
    }

    public static function show($id) {
        $task = Task::find($id);
        View::make('task/show.html', array(
            'name' => $task->name,
            'description' => $task->description,
            'deadline' => $task->deadline));
    }

}
