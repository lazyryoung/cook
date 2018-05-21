<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
//require 'lib/db.php';

$app = new \Slim\App;
$app->get('/', function($request, $response, $args) {
    return $response->withRedirect('home.php', 301);
    //return $response->withStatus(200)->write('Hello world!');
});
$app->get('/test', function($request, $response, $args) {
    return $response->withStatus(200)->write('Hello world!');
});
$app->get('/hello/{name}', function(Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
});

// abouts Routes
//require 'routes/abouts.php';

$app->run();