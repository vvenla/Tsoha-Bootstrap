<?php

function check_logged_in(){
    BaseController::check_logged_in();
}

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/', 'check_logged_in', function() {
    CategoryController::index();
});

$routes->get('/main', 'check_logged_in', function() {
    CategoryController::index();
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
$routes->post('/task/new',  'check_logged_in', function() {
    TaskController::store();
});

//Tehtävän esittelysivu
$routes->get('/task/:id/view', 'check_logged_in', function($id) {
    TaskController::show($id);
});

//Tehtävän esittely- ja muokkaussivu
$routes->get('/task/:id/edit', 'check_logged_in', function($id) {
    TaskController::edit($id);
});

//Tehtävän päivittäminen
$routes->post('/task/:id/edit', 'check_logged_in', function($id) {
    TaskController::update($id);
});

//Tehtävän siirtäminen kategoriaan
$routes->post('/task/:id/move', 'check_logged_in', function($category_id) {
    TaskController::move($category_id);
});

//Tehtävän poistaminen
$routes->post('/task/:id/delete', 'check_logged_in', function($id) {
    TaskController::delete($id);
});

// Tehtävät deadlinen mukaan järjestettynä
$routes->get('/task/deadlines', 'check_logged_in', function() {
    TaskController::show_deadlines();
});


$routes->get('/category/new', 'check_logged_in', function() {
    CategoryController::create();
});

$routes->post('/category/new', 'check_logged_in', function() {
    CategoryController::store();
});

$routes->get('/category/:id', 'check_logged_in', function($id) {
    CategoryController::show($id);
});

$routes->get('/category', 'check_logged_in', function() {
    CategoryController::index();
});

//Kategorian poistaminen
$routes->post('/category/:id/delete', 'check_logged_in', function($id) {
    CategoryController::delete($id);
});

//Kategorian muokkaussivu
$routes->get('/category/:id/edit', 'check_logged_in', function($id) {
    CategoryController::edit($id);
});

//Kategorian päivittäminen
$routes->post('/category/:id/edit', 'check_logged_in', function($id) {
    CategoryController::update($id);
});

// Tehtävävän jakaminen muille
$routes->post('/task/:id/share', 'check_logged_in', function($id) {
    TaskController::share($id);
});
        
