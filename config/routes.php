<?php

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/main', function() {
    HelloWorldController::todo_show();
});

$routes->get('/class', function() {
    HelloWorldController::todo_addClass();
});

//$routes->get('/', function() {
//    TaskController::index();
//});

//Kirjautumislomakkeen näyttäminen
$routes->get('/login', function() {
    UserController::login();
});

//Kirjautumisen käsitteleminen
$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->get('/task', function() {
    TaskController::index();
});

//Uuden tehtävän lisäämislomakkeen näyttäminen
$routes->get('/task/new', function() {
    TaskController::create();
});

//Uuden tehtävän lisääminen tietokantaan
$routes->post('/task/new', function() {
    TaskController::store();
});

//Tehtävän esittely- ja muokkaussivu
$routes->get('/task/:id/edit', function($id) {
    TaskController::edit($id);
});

//Tehtävän päivittäminen
$routes->post('/task/:id/edit', function($id) {
    TaskController::upd($id);
});

//Tehtävän poistaminen
$routes->post('/task/:id/delete', function($id) {
    TaskController::del($id);
});

$routes->post('/category', function() {
    TaskController::store();
});

$routes->get('/category/new', function() {
    TaskController::create();
});

$routes->get('/category/:id', function($id) {
    TaskController::show($id);
});
