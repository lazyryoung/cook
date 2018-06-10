<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

// Get Single abouts
$app->get('/api/memos/{num}' , function(Request $request , Response $response) {

    // GET DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $num = $request->getAttribute('num');

    $sql = "select * from cook_memo where num=:num";

    try{

        //$stmt = $db->query($sql);
        $stmt = $db->prepare($sql);
        //$num = filter_input(INPUT_GET, "num", FILTER_SANITIZE_NUMBER_INT); //slim에서는 필요없는 듯
        $stmt->bindParam(":num",$num, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            $resultData = array('result' => '404', 'message' => '리소스가 존재하지 않습니다.', 'data' => '{"error" : {"text" : "존재하지 않는 글입니다."}}');
            return $response
                    ->withStatus(404, '리소스가 존재하지 않습니다.')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }
        $memos = $stmt->fetchAll(PDO::FETCH_OBJ); //FETCH_ASSOC
        $db = null;
        //https://m.blog.naver.com/wildr0se/220599750842
        $resultData = array('result' => '200', 'message' => '성공', 'data' => $memos);
        return $response
                ->withStatus(200, '성공')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        //echo json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

    }catch(Exception $e){
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        return $response
                ->withStatus(500, '오류가 발생했습니다.')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }

    return $response;
});


// Get All Customers
$app->get('/api/memos' , function(Request $request , Response $response){

    // GET DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $page = $request->getParam('page', $default=1);
    $offset = $request->getParam('offset', $default=10);
    $start_limit = ($page - 1) * $offset;

    //$sql = "select * from cook_memo order by num desc limit $start_limit, $offset";
    $sql = "select * from cook_memo order by num desc limit :start_limit, :offset";

    try{

        //http://servedev.tistory.com/42
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //limit(동적쿼리) 로 인해 사용, true로 하면 오류

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':start_limit',$start_limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset',$offset, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $resultData = array('result' => '404', 'message' => '리소스가 존재하지 않습니다.', 'data' => '{"error" : {"text" : "존재하지 않는 글입니다."}}');
            return $response
                    ->withStatus(404, '리소스가 존재하지 않습니다.')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }

        $memos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $resultData = array('result' => '200', 'message' => '조회했습니다.', 'data' => $memos);
        return $response
                    ->withStatus(200, '입력했습니다.')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

    }catch(Exception $e){
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        return $response
                    ->withStatus(500, '입력했습니다.')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

    }
});

// insert memo
$app->post('/api/memos' , function(Request $request , Response $response){
    //echo 'CUSTOMERS';

    // GET DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $_SESSION['userid'] = "sedan";
    if (!isset($_SESSION['userid'])) {
        $resultData = array('result' => '401', 'message' => '인증이 필요합니다.', 'data' => '{"error" : {"text" : ""}}');
        return $response
                ->withStatus(401, '인증이 필요합니다..')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }

    $data = $request->getParsedBody(); //application/x-www-form-urlencoded, multipart/form-data

    $key_arr = array('id', 'name', 'nick', 'content');
    foreach ($key_arr as $key_name) {
        if (!array_key_exists($key_name, $data) || empty($data[$key_name])) {
            $resultData = array('result' => '400', 'message' => '잘못된 요청입니다.', 'data' => '{"error" : {"text" : '.$key_name.'"의 값이 없습니다."}}');
            return $response
                    ->withStatus(400, '잘못된 요청입니다.')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }
    }

    $memos = [];
    $memos['id'] = filter_var($data['id'], FILTER_SANITIZE_STRING); //빈 값이 db에 적용되기 시작
    $memos['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $memos['nick'] = filter_var($data['nick'], FILTER_SANITIZE_STRING);
    $memos['content'] = filter_var($data['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); //htmlspecialchars

    $sql = "INSERT INTO cook_memo(id, name, nick, content, regist_day)";
    $sql .= " VALUES(:id, :name, :nick, :content, :regist_day)";

    try{

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$memos['id'], PDO::PARAM_STR);
        $stmt->bindParam(':name',$memos['name'], PDO::PARAM_STR);
        $stmt->bindParam(':nick',$memos['nick'], PDO::PARAM_STR);
        $stmt->bindParam(':content',$memos['content'], PDO::PARAM_STR);
        $stmt->bindParam(':regist_day',date("Y-m-d(H:i)"), PDO::PARAM_STR);

        $db->beginTransaction();
        $stmt->execute();
        $memos['num'] = $db->lastInsertId(); //commit 전 호출해야함
        $db->commit();


        $db = null;
        $resultData = array('result' => '201', 'message' => '성공', 'data' => $memos);
        return $response
            ->withHeader('Location','/cook/api/memos/'.$memos['num'])
            ->withStatus(201, '입력했습니다.')
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));


    }catch(Exception $e){
        $db->rollBack();
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        return $response
                ->withStatus(500, '오류가 발생했습니다.')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

    }
});

// update memo
$app->put('/api/memos/{num}' , function(Request $request , Response $response){
    //echo 'CUSTOMERS';

    // GET DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $num = $request->getAttribute('num');

    //인증검사
    $_SESSION['userid'] = "sedan";
    if (!isset($_SESSION['userid'])) {
        $resultData = array('result' => '401', 'message' => '인증이 필요합니다.', 'data' => '{"error" : {"text" : ""}}');
        $response->withStatus(401, '인증이 필요합니다..')->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return $response;
    }

    $data = $request->getParsedBody(); //application/x-www-form-urlencoded, multipart/form-data

    //필수정보 체크
    $key_arr = array('id', 'name', 'nick', 'content');
    foreach ($key_arr as $key_name) {
        if (!array_key_exists($key_name, $data) || empty($data[$key_name])) {
            $resultData = array('result' => '400', 'message' => '필수정보가 누락되었습니다.', 'data' => '{"error" : {"text" : '.$key_name.'"의 값이 없습니다."}}');
            $response->withStatus(400, '필수정보가 누락되었습니다.')->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
            return $response;
        }
    }

    //수정권한과 리로스 존재여부 검사, 역시 middleware로...
    $sql = "SELECT id FROM cook_memo WHERE num=:num";
    try{
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':num',$num, PDO::PARAM_INT);
        //$stmt->bindParam(':id',$_SESSION['userid'], PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //echo "rowcount:".$stmt->rowCount();
        //return $response;

        if ($stmt->rowCount() == 0) {
            $resultData = array('result' => '404', 'message' => '리소스가 존재하지 않습니다.', 'data' => '{"error" : {"text" : "존재하지 않는 글입니다."}}');
            return $response
                    ->withStatus(404, '리소스가 존재하지 않습니다.')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }
        //배열처리없이 칼럼 하나만 가져오는 건 없낭?
        if ($result['id'] != $_SESSION['userid']) {
            $resultData = array('result' => '403', 'message' => '권한이 필요합니다.', 'data' => '{"error" : {"text" : "작성자만 수정할 수 있습니다."}}');
            return $response
                    ->withStatus(403, '권한이 필요합니다..')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }

    }catch(Exception $e){
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        //나중에 로그로 남기며 정확한 exception은 client에 보내지 않기로 변경해야함.
        $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        return $response
                ->withStatus(500, '입력했습니다.')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }

    $memos = [];
    $memos['id'] = filter_var($data['id'], FILTER_SANITIZE_STRING); //빈 값이 db에 적용되기 시작
    $memos['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $memos['nick'] = filter_var($data['nick'], FILTER_SANITIZE_STRING);
    $memos['content'] = filter_var($data['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); //htmlspecialchars

    $sql = "UPDATE cook_memo SET name = :name, nick = :nick, content = :content";
    $sql .= " WHERE num = :num AND id = :id ";

    try{

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':num',$num, PDO::PARAM_INT);
        $stmt->bindParam(':id',$memos['id'], PDO::PARAM_STR);
        $stmt->bindParam(':name',$memos['name'], PDO::PARAM_STR);
        $stmt->bindParam(':nick',$memos['nick'], PDO::PARAM_STR);
        $stmt->bindParam(':content',$memos['content'], PDO::PARAM_STR);

        $db->beginTransaction();
        $stmt->execute();

        //여러개가 업로드되면 안됨, 보통은 일어나지 않음.
        if ($stmt->rowCount() > 1) {
            $db->rollBack();
            //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
            $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : ""}}');
            return $response
                ->withStatus(500, '오류가 발생했습니다.')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }
        $db->commit();


        $db = null;
        $resultData = array('result' => '200', 'message' => '수정했습니다.', 'data' => $memos);
        return $response
            ->withStatus(200, '수정했습니다.')
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));


    }catch(Exception $e){
        $db->rollBack();
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        return $response
                ->withStatus(500, '오류가 발생했습니다.')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

    }
});

// update memo
$app->delete('/api/memos/{num}' , function(Request $request , Response $response){
    //echo 'CUSTOMERS';

    // GET DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $num = $request->getAttribute('num');

    //인증검사
    $_SESSION['userid'] = "sedan";
    if (!isset($_SESSION['userid'])) {
        $resultData = array('result' => '401', 'message' => '인증이 필요합니다.', 'data' => '{"error" : {"text" : ""}}');
        $response->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return $response->withStatus(401, '인증이 필요합니다..');
    }

    $data = $request->getParsedBody(); //application/x-www-form-urlencoded, multipart/form-data

    //삭제권한과 리로스 존재여부 검사, 역시 middleware로...
    $sql = "SELECT id FROM cook_memo WHERE num=:num";
    try{
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':num',$num, PDO::PARAM_INT);
        //$stmt->bindParam(':id',$_SESSION['userid'], PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //echo "rowcount:".$stmt->rowCount();
        //return $response;

        if ($stmt->rowCount() == 0) {
            $resultData = array('result' => '404', 'message' => '리소스가 존재하지 않습니다.', 'data' => '{"error" : {"text" : "존재하지 않는 글입니다."}}');
            $response->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
            return $response->withStatus(404, '리소스가 존재하지 않습니다.');
        }
        //배열처리없이 칼럼 하나만 가져오는 건 없낭?
        if ($result['id'] != $_SESSION['userid']) {
            $resultData = array('result' => '403', 'message' => '권한이 필요합니다.', 'data' => '{"error" : {"text" : "작성자만 수정할 수 있습니다."}}');
            return $response
                    ->withStatus(403, '권한이 필요합니다..')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }

    }catch(Exception $e){
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        //나중에 로그로 남기며 정확한 exception은 client에 보내지 않기로 변경해야함.
        $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        return $response
                ->withStatus(500, '입력했습니다.')
                ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }

    $sql = "DELETE FROM cook_memo";
    $sql .= " WHERE num = :num AND id = :id";

    try{

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':num',$num, PDO::PARAM_INT);
        $stmt->bindParam(':id',$_SESSION['userid'], PDO::PARAM_STR);

        $db->beginTransaction();
        $stmt->execute();

        //여러개가 삭제되면 안됨, 보통은 일어나지 않음.
        if ($stmt->rowCount() > 1) {
            $db->rollBack();
            //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
            $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : "서버개발자에게 문의하세요."}}');
            return $response
                    ->withStatus(500, '오류가 발생했습니다.')
                    ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }
        $db->commit();


        $db = null;
        $resultData = array('result' => '200', 'message' => '삭제했습니다.', 'data' => '');
        return $response
            ->withStatus(200, '삭제했습니다.')
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));


    }catch(Exception $e){
        $db->rollBack();
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        $resultData = array('result' => '500', 'message' => '오류가 발생했습니다.', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        return $response
            ->withStatus(500, '오류가 발생했습니다.')
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

    }
});
?>