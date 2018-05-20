<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get Single abouts
$app->get('/api/abouts/{num}' , function(Request $request , Response $response) {

    $num = $request->getAttribute('num');
    $sql = "select * from cook_about where num=$num";

    try{
        // GET DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $abouts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //https://m.blog.naver.com/wildr0se/220599750842
        echo json_encode($abouts, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

    }catch(PDOEception $e){
        echo '{"error" : {"text" : '.$e->getMessage().'}}';

    }

});


// Get All Customers
$app->get('/api/abouts' , function(Request $request , Response $response){
    //echo 'CUSTOMERS';
    $sql = "SELECT * FROM cook_about";

    try{
        // GET DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $abouts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($abouts,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

    }catch(PDOEception $e){
        echo '{"error" : {"text" : '.$e->getMessage().'}}';

    }
});

// Add  Customers
$app->post('/api/customers/add' , function(Request $request , Response $response){

    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state)
VALUES(:first_name,:last_name,:phone,:email,:address,:city,:state)";

    try{
        // GET DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name' , $first_name);
        $stmt->bindParam(':last_name' , $last_name);
        $stmt->bindParam(':phone' , $phone);
        $stmt->bindParam(':email' , $email);
        $stmt->bindParam(':address' , $address);
        $stmt->bindParam(':city' , $city);
        $stmt->bindParam(':state' , $state);

        $stmt->execute();

        echo '{"notice" : {"text" : "Customer Add! "} }';

    }catch(PDOEception $e){
        echo '{"error" : {"text" : '.$e->getMessage().'}}';

    }
});

?>