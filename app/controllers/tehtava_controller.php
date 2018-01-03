<?php

class TehtavaController extends BaseController {

    public static function index() {
        $tehtavat = Tehtava::all();
        View::make('tehtava/index.html', array('tehtavat' => $tehtavat));
    }

    public static function create() {
        $tehtavat = Tehtava::all();
        View::make('tehtava/new.html', array('tehtavat' => $tehtavat));
    }

    public static function store() {
        $params = $_POST;
        $tehtava = new Tehtava(array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'deadline' => $params['deadline'],
        ));


        $tehtava->save();
        Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtävä on lisätty listalle!'));
    }

    public static function show($id) {
        $tehtava = Tehtava::find($id);
        View::make('tehtava/show.html', array('nimi' => $tehtava->nimi, 'kuvaus' => $tehtava->kuvaus, 'deadline' => $tehtava->deadline));
    }

}
