<?php

class CategoryController extends BaseController {

    public static function index() {
        $user_logged_in = self::get_user_logged_in();

        $tasks_without_category = Task::all_tasks_without_category($user_logged_in->id);


        $categories = Category::all($user_logged_in->id);

        $tasks = array();

        foreach ($categories as $category) {

            $category->tasks = Task::all_tasks_in_category($user_logged_in->id, $category->id);
            
        }

        View::make('category/index.html', array(
            'tasks_without_category' => $tasks_without_category,
            'categories' => $categories,
            'tasks' => $tasks));
    }

    public static function show($id) {
        $user_logged_in = self::get_user_logged_in();
        $category = Category::find($id);

        if ($category->is_owned_by($user_logged_in->id)) {
            View::make('category/edit.html', array('category' => $category));
        } else {
            Redirect::to('/main', array('error' => 'Category not found'));
        }
    }

    public static function create() {
        View::make('category/new.html');
    }

    public static function store() {
        $user_logged_in = self::get_user_logged_in();

        $params = $_POST;

        $attributes = array(
            'personid' => $user_logged_in->id,
            'name' => trim($params['name'])
        );

        $category = new Category($attributes);
        $errors = $category->errors();

        if (count($errors) == 0) {
            $category->save();
            Redirect::to('/main', array('message' => 'Category added'));
        } else {
            View::make('/category/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function edit($id) {
        $user_logged_in = self::get_user_logged_in();
        $category = Category::find($id);

        if ($category->is_owned_by($user_logged_in->id)) {
            View::make('category/edit.html', array('attributes' => $category));
        } else {
            Redirect::to('/main', array('error' => 'Category not found'));
        }
    }

    public static function update($id) {
        $user_logged_in = self::get_user_logged_in();

        $params = $_POST;

        $attributes = array(
            'name' => trim($params['name']),
            'id' => $id
        );

        $category = new Category($attributes);
        $errors = $category->errors();

        if (!$category->is_owned_by($user_logged_in->id)) {
            Redirect::to('/main', array('error' => 'Category not found'));
        }
        if (count($errors) == 0) {
            $category->update();
            Redirect::to('/main', array('message' => 'Category edited'));
        } else {
            View::make('category/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function delete($id) {
        $user_logged_in = self::get_user_logged_in();
        $category = new Category(array('id' => $id));

        if (!$category->is_owned_by($user_logged_in->id)) {
            Redirect::to('/main', array('error' => 'Category not found'));
        } else if (!$category->is_empty()) {
            Redirect::to('/main', array('error' => 'Category can not be deleted if it is not empty'));
        } else {
            $category->delete();
            Redirect::to('/main', array('message' => 'Category deleted'));
        }
    }

}
