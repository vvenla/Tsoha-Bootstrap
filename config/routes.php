<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/main', function() {
    HelloWorldController::todo_show();
});

//$routes->get('/todo', function() {
//    HelloWorldController::todo_add();
//});

$routes->get('/class', function() {
    HelloWorldController::todo_addClass();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/luokka', function() {
    LuokkaController::index();
});

$routes->get('/tehtava', function() {
    TehtavaController::index();
});

//Tehtävän lisääminen tietokantaan
$routes->post('/tehtava', function() {
    TehtavaController::store();
});

//tehtävän lisäämislomakkeen näyttäminen
$routes->get('/tehtava/new', function() {
    TehtavaController::create();
});

$routes->post('/tehtava/new', function() {
    TehtavaController::store();
});

//Tehtävän esittelysivu
$routes->get('/tehtava/:id', function($id) {
    TehtavaController::show($id);
});

$routes->post('/luokka', function() {
    TehtavaController::store();
});

$routes->get('/luokka/new', function() {
    TehtavaController::create();
});

$routes->get('/luokka/:id', function($id) {
    TehtavaController::show($id);
});
