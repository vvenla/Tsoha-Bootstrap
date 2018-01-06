<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on todellankin etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        $tehtava = new Task(array(
            'name' => '',
            'deadline' => 'eilen'
        ));
        $errors = $tehtava->errors();

        Kint::dump($errors);
//        View::make('helloworld.html');
    }

    public static function todo_add() {
        View::make('suunnitelmat/tehtavanLisays.html');
    }

    public static function todo_addClass() {
        View::make('suunnitelmat/luokanLisays.html');
    }

    public static function todo_show() {
        View::make('suunnitelmat/paanakyma.html');
    }

    public static function login() {
        View::make('suunnitelmat/kirjautuminen.html');
    }

}
