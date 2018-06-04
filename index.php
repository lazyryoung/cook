<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/*
$config['db']['host']   = 'localhost';
$config['db']['user']   = 'user';
$config['db']['pass']   = 'password';
$config['db']['dbname'] = 'exampleapp';
*/

require '../../vendor/autoload.php';
require 'lib/db.php';

$config['displayErrorDetails'] = true; //오류 표시
$config['addContentLengthHeader'] = false;

//$app = new \Slim\App;
$app = new \Slim\App(['settings' => $config]);  //설정을 사용가능하도록 한다.
$container = $app->getContainer();  //container : DI 추가

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

$app->get('/', function($request, $response, $args) {
    return $response->withRedirect('home.php', 301);
    //return $response->withStatus(200)->write('Hello world!');
});
$app->get('/test', function($request, $response, $args) {
    return $response->withStatus(200)->write('Hello world!');
});
//$app->get('/hello/{name}', function(Request $request, Response $response) {
$app->get('/hello/{name}', function(Request $request, Response $response, $args) {
    //$this->logger->addInfo('Something interesting happened');
    //$name = $request->getAttribute('name');
    $name = $args['name'];
    $response->ge/Library/WebServer/DocumentstBody()->write("Hello, $name");
    //$response = $this->view->render($response, 'tickets.phtml', ['tickets' => $tickets]);
    return $response;
});

/*
$app->post('/ticket/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $ticket_data = [];
    $ticket_data['title'] = filter_var($data['title'], FILTER_SANITIZE_STRING);
    $ticket_data['description'] = filter_var($data['description'], FILTER_SANITIZE_STRING);
    // ...*/

/*
$app->get('/ticket/{id}', function (Request $request, Response $response, $args) {
    // ...
})->setName('ticket-detail');

$response = $this->view->render($response, 'tickets.phtml', ['tickets' => $tickets, 'router' => $this->router]);
*/

// abouts Routes
require 'routes/abouts.php';

$app->run();