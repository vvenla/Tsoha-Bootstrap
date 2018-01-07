<?php

function check_logged_in(){
    BaseController::check_logged_in();
}

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

//Uloskirjautumisen käsitteleminen
$routes->post('/logout', function() {
    UserController::handle_logout();
});

$routes->get('/task', 'check_logged_in', function() {
    TaskController::index();
});

//Uuden tehtävän lisäämislomakkeen näyttäminen
$routes->get('/task/new', 'check_logged_in', function() {
    TaskController::create();
});

//Uuden tehtävän lisääminen tietokantaan
$routes->post('/task/new', function() {
    TaskController::store();
});

//Tehtävän esittely- ja muokkaussivu
$routes->get('/task/:id/edit', 'check_logged_in', function($id) {
    TaskController::edit($id);
});

//Tehtävän päivittäminen
$routes->post('/task/:id/edit', 'check_logged_in', function($id) {
    TaskController::upd($id);
});

//Tehtävän poistaminen
$routes->post('/task/:id/delete', 'check_logged_in', function($id) {
    TaskController::del($id);
});

$routes->post('/category', function() {
    CategoryController::store();
});

$routes->get('/category/new', function() {
    CategoryController::create();
});

$routes->get('/category/:id', function($id) {
    CategoryController::show($id);
});
