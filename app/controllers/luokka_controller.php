<?php

class LuokkaController extends BaseController{
    
    public static function index(){
        $luokat = Luokka::all();
        View::make('luokka/index.html', array('luokat' => $luokat));
    }
}

