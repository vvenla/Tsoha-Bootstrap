<?php

class CategoryController extends BaseController {

    public static function index() {
        $user_logged_in = self::get_user_logged_in();
        $categories = Category::all($user_logged_in->id);

        View::make('category/index.html', array('categories' => $categories));
    }

    public static function show($id) {
        $user_logged_in = self::get_user_logged_in();
        $category = Category::find($id);

        if ($category->is_owned_by($user_logged_in->id)) {
            View::make('category/edit.html', array('category' => $category));
        } else {
            Redirect::to('/category', array('error' => 'Category not found'));
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
            Redirect::to('/category', array('message' => 'Category added'));
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
            Redirect::to('/category', array('error' => 'Category not found'));
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
            Redirect::to('/category', array('error' => 'Category not found'));
        }
        if (count($errors) == 0) {
            $category->update();
            Redirect::to('/category', array('message' => 'Category edited'));
        } else {
            View::make('category/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function delete($id) {
        $user_logged_in = self::get_user_logged_in();
        $category = new Category(array('id' => $id));

        if (!$category->is_owned_by($user_logged_in->id)) {
            Redirect::to('/category', array('error' => 'Category not found'));
        } else if (!$category->is_empty()) {
            Redirect::to('/category', array('error' => 'Category can not be deleted if it is not empty'));
        } else {
            $category->delete();
            Redirect::to('/category', array('message' => 'Category deleted'));
        }
    }

}
