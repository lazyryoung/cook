<?php

require '../../../vendor/autoload.php';
require 'lib/db.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\UploadedFile;

/*
$config['db']['host']   = 'localhost';
$config['db']['user']   = 'user';
$config['db']['pass']   = 'password';
$config['db']['dbname'] = 'exampleapp';
*/


$config['displayErrorDetails'] = true; //오류 표시
$config['addContentLengthHeader'] = false;

//$app = new \Slim\App;
$container = new \Slim\Container(['settings' => $config]); //container : DI 추가(pre)
//$app = new \Slim\App(['settings' => $config]);  //설정을 사용가능하도록 한다.
//$container = $app->getContainer();  //container : DI 추가(post)
//$container = new \Slim\Container();
$container['temp_uploads'] = __DIR__ . '/temp_uploads';
$container['uploads'] = __DIR__ . '/uploads';
$container['upload_errors'] = array(
    0 => '오류 없이 파일 업로드가 성공했습니다.',
    1 => '업로드한 파일이 php.ini upload_max_filesize 지시어보다 큽니다.',
    2 => '업로드한 파일이 HTML 폼에서 지정한 MAX_FILE_SIZE 지시어보다 큽니다.',
    3 => '파일이 일부분만 전송되었습니다.',
    4 => '파일이 전송되지 않았습니다.',
    6 => '임시 폴더가 없습니다.',
    7 => '디스크에 파일 쓰기를 실패했습니다.',
    8 => '확장에 의해 파일 업로드가 중지되었습니다.',
);  //https://secure.php.net/manual/kr/features.file-upload.errors.php

$container['logger'] = function($container) {
    //$logger = new \Monolog\Logger('my_logger');
    //$file_handler = new \Monolog\Handler\StreamHandler('../../logs/app.log');
    //$logger->pushHandler($file_handler);
    //return $logger;
};

$container['errorHandler'] = function ($container) {
    return new CookExceptionHandler();
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($container) {     //function($)c로 해도 재정의가 됨...
    return function ($request, $response) use ($container) {
        $resultData = array('result' => '404', 'message' => 'Not Found', 'data' => '{"error" : {"text" : "리소스가 존재하지 않습니다."}}');
        return $container['response']
            ->withStatus(404, 'Not Found')
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    };
};
//cors에서 정의되지 않은 메소드는 500에러로 처리됨...
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        $resultData = array('result' => '405'
                    , 'message' => 'Method Not Allowed'
                    , 'data' => '{"error" : {"text" : "허용되지 않은 접근입니다. 접근 메소드는 '. implode(',', $methods) . '중 하나여야 합니다."}}');
        return $container['response']
            ->withStatus(405, 'Method Not Allowed')
            ->withHeader('Allow', implode(', ', $methods))
            //->withHeader('Content-type', 'text/html')
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    };
};

//정확히 무얼 의미하는지? 인터프리터 문제인지? php 7만 가능하다함.
//https://secure.php.net/manual/en/class.error.php
//이걸로 로그저장이 가능할 듯...
//PHP Fatal error:  Uncaught Error 는 잡히지 않낭?
$container['phpErrorHandler'] = function ($container) {
    return function ($request, $response, $error) use ($container) {
        $resultData = array('result' => '500'
        , 'message' => 'Internal Server Error'
        , 'data' => '{"error" : {"text" : "['. $error->getCode() .']'. $error->getMessage() . '"}}');
        return $container['response']
            ->withStatus(500, 'Internal Server Error')
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    };
};

$app = new \Slim\App($container);  //설정을 사용가능하도록 한다.
//에러처리 해제
//unset($app->getContainer()['errorHandler']);
//unset($app->getContainer()['phpErrorHandler']);

//이걸 쓰면 존재하지 않는 리소스에도 405를 적용하게 됨. 아마도... 모든 라우트에 적용되게 되어 있어서인 듯.
//$app->options('/{routes:.+}', function ($request, $response, $args) {
//    return $response;
//});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'https://localhost')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

//임시며 middleware는 나중에 적용
session_start();

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
    $response->withStatus(200)->write("Hello, $name");
    //$response = $this->view->render($response, 'tickets.phtml', ['tickets' => $tickets]);
    return $response;
});
$app->get('/hello/pathFor/{name}', function ($request, $response, $args) {
    echo "Hello, " . $args['name'];
})->setName('hi');


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


//test....
// abouts Routes
require 'routes/abouts.php';
require 'routes/memos.php';

/**
 * Moves the uploaded file to the upload directory and assigns it a unique name
 * to avoid overwriting an existing uploaded file.
 *
 * @param string $directory directory to which the file is moved
 * @param UploadedFile $uploaded file uploaded file to move
 * @return string filename of moved file
 */
function moveUploadedFile($directory, $b_type, UploadedFile $uploadedFile)
{
//    echo var_dump($directory);
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION); //확장자를 가져온다.
    //https://secure.php.net/manual/en/function.bin2hex.php
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $b_type. DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

/**
 * Class
 */
Class CookException extends Exception {

    //http 상태 코드, 오류 메시지
    //protected
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
//Exception ha
class CookExceptionHandler {
    public function __invoke($request, $response, $exception) {

        $resultData = (!$exception instanceof CookException)
            ? array('result' => '500', 'message' => '', 'data' => '{"error" : {"text" : "오류가 발생했습니다."}}')
            : json_decode($exception->getMessage(), true);
        $statusCode = $resultData['result'];
        //var_dump((int)$statusCode);
        //echo $exception->getTraceAsString();
        return $response
            ->withStatus((int)$statusCode)
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }
}
$app->run();