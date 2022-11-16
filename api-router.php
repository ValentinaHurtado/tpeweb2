<?php
require_once './libs/Router.php';
require_once './app/controller/apiController.php';

$router=new Router();

// defina la tabla de ruteo
$router->addRoute('libros', 'GET', 'ApiController', 'getAll');
$router->addRoute('libros/:ID', 'GET', 'ApiController', 'getLibroById');
$router->addRoute('libros/:ID', 'DELETE', 'ApiController', 'deleteLibro');
$router->addRoute('libros', 'POST', 'ApiController', 'addLibro'); 
$router->addRoute('libros/:ID', 'PUT', 'ApiController', 'editLibro');


// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);