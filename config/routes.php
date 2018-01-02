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
$routes->get('/todo', function() {
    HelloWorldController::todo_add();
});

$routes->get('/class', function() {
    HelloWorldController::todo_addClass();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/luokka', function(){
  LuokkaController::index();
});

$routes->get('/tehtava', function(){
    TehtavaController::index();
});