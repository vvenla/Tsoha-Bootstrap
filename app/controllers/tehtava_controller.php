<?php

class TehtavaController extends BaseController{
    
    public static function index(){
        $tehtavat = Tehtava::all();
        View::make('tehtava/index.html', array('tehtavat' => $tehtavat));
    }
}

