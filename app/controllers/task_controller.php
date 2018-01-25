<?php

class TaskController extends BaseController {

    public static function index() {
        $user_logged_in = self::get_user_logged_in();


        $tasks = Task::all_users_tasks($user_logged_in->id);
        $categories = Category::all($user_logged_in->id);

        View::make('task/index.html', array('tasks' => $tasks, 'categories' => $categories));
    }

    public static function create() {
        $user_logged_in = self::get_user_logged_in();
        $tasks = Task::all_users_tasks($user_logged_in->id);
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
            $task->save($user_logged_in->id);

            Redirect::to('/main', array('message' => 'Task added!'));
        } else {
            View::make('/task/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function show($task_id) {
        $task = Task::find($task_id);
        $user = self::get_user_logged_in();
       
        $users = User::find_users_shared($user->id, $task_id);
        
        View::make('task/view.html', array(
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'deadline' => $task->deadline,
            'users' => $users
        ));
    }
    
    public static function show_deadlines() {
        $user = self::get_user_logged_in();
        $tasks = Task::deadlines($user->id);
        
        View::make('task/deadlines.html', array('tasks' => $tasks));
    }

    public static function edit($id) {
        $user_logged_in = self::get_user_logged_in();

        $task = Task::find($id);
        $users = User::find_other_users($task->id);
        $shared_with = User::find_users_shared($user_logged_in->id, $task->id);
        View::make('task/show.html', array(
            'attributes' => $task,
            'users' => $users,
            'shared_with' => $shared_with
        ));
    }

    public static function update($id) {

        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'name' => trim($params['name']),
            'description' => trim($params['description']),
            'deadline' => $params['deadline']
        );

        $task = new Task($attributes);

        if (empty($params['users'])) {
            $users = array();
        } else {
            $users = $params['users'];
        }


        foreach ($users as $user) {


            $task->share_with($user);
        }

        if ($task->deadline == '') {
            $task->deadline = NULL;
        }

        $errors = $task->errors();
        if (count($errors) == 0) {
            $task->update();

            Redirect::to('/main', array('message' => 'Task updated!'));
        } else {
            View::make('/task/show.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function move($task_id) {
        $user_logged_in = self::get_user_logged_in();

        $params = $_POST;

        $task = Task::find($task_id);


        if ($params['categoryid'] == -1) {
            $task->set_category(NULL, $user_logged_in->id);
            Redirect::to('/main', array('message' => 'Task removed from category'));
        } else if ($params['categoryid'] == -2) {
            Redirect::to('/main', array('message' => 'Choose the category'));
        } else {
            $task->set_category($params['categoryid'], $user_logged_in->id);
            Redirect::to('/main', array('message' => 'Task moved to category'));
        }
    }

//    public static function share($task_id) {
//        $params = $_POST;
//        
//        $task = Task::find($task_id);
//        
//        $task->share_with($params['userid']);
//        Redirect::to('/task/show.html', array('message' => 'Task shared'));
//        
//    }

    public static function delete($id) {
        $task = new Task(array('id' => $id));
        $task->delete();

        Redirect::to('/main', array('message' => 'Task completed!'));
    }

}
