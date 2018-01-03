<?php

class CategoryController extends BaseController{
    
    public static function index(){
        $categories = Category::all();
        View::make('category/index.html', array('categories' => $categories));
    }
}

