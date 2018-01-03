<?php

$routes->get('/', function() {
    TaskController::index();
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

$routes->get('/category', function() {
    CategoryController::index();
});

$routes->get('/task', function() {
    TaskController::index();
});

//Tehtävän lisääminen tietokantaan
$routes->post('/task', function() {
    TaskController::store();
});

//tehtävän lisäämislomakkeen näyttäminen
$routes->get('/task/new', function() {
    TaskController::create();
});

$routes->post('/task/new', function() {
    TaskController::store();
});

//Tehtävän esittelysivu
$routes->get('/task/:id', function($id) {
    TaskController::show($id);
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
