<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;
use Tuupola\Base62;

// insert memo
$app->post('/api/signin' , function(Request $request , Response $response) {
    //echo 'CUSTOMERS';

    // GET DB Object
    $db = new db();
    // Connect
    $db = $db->connect();


    //필수필드조사
    //업로드가 안되는 경우에는 폼데이타도 넘어오지 않아서 여기서부터 오류가 발생함.
    $data = $request->getParsedBody(); //application/x-www-form-urlencoded, multipart/form-data, post만 됨...
    $key_arr = array('id', 'password');
    foreach ($key_arr as $key_name) {
        if (!array_key_exists($key_name, $data) || empty($data[$key_name])) {
            $resultData = array('result' => '400', 'message' => '', 'data' => '{"error" : {"text" : ' . $key_name . '"의 값이 없습니다."}}');
            throw new CookException(json_encode($resultData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
    }

    $signin = [];
    $signin['id'] = filter_var($data['id'], FILTER_SANITIZE_STRING); //빈 값이 db에 적용되기 시작해서 필드 유효성 검사 적용
    $signin['password'] = filter_var($data['password'], FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM cook_member where id = :id";

    try{

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$signin['id'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetchObject();


        // verify email address.
        if(!$user) {
            $resultData = array('result' => '401', 'message' => '', 'data' => '사용자 정보가 없습니다.');
            throw new CookException(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }

        // verify password.
        //if (!password_verify($input['password'],$user->password)) {
        if ($data['password'] !== $user->password) {
            $resultData = array('result' => '401', 'message' => '', 'data' => '인증정보가 다릅니다.');
            throw new CookException(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }

        $settings = $this->get('jwt'); // get settings array.

        /* Here generate and return JWT to the client. */
        //$valid_scopes = [“read”, “write”, “delete”]
        //$requested_scopes = $request->getParsedBody() ?: [];
        $now = new DateTime();
        $term = new DateInterval('PT1H'); //10hour
        $future = (new DateTime())->add($term);
        $server = $request->getServerParams();
        $jti = (new Base62)->encode(random_bytes(16));
        // 배열을 만들어서 arg로 넘기는 방식은 안됨...왜지? key는 되도록 홑따음표로...
        $payload = [
            'iat' => $now->getTimeStamp(),
            'exp' => $future->getTimeStamp()
            //“jti” => $jti
            //“sub” => $server[“PHP_AUTH_USER”]
            //“sub” => $user
        ];
        //$secret = “123456789helo_secret”;
        //var_dump($now);
        //var_dump($future);
        //$token = JWT::encode($payload, $settings['secret'], “HS384”);
        //$token = JWT::encode(['id' => $user->id, 'email' => $user->email], $settings['secret'], "HS384");
        $token = JWT::encode(['iat' => $now->getTimeStamp(), 'exp' => $future->getTimeStamp(), 'jti' => $jti, 'user' => $user, 'scope' => ['read', 'write', 'delete'] ], $settings['secret'], "HS384"); //exp 이후에는 인증이 끊김.
        $result['token'] = $token;
        $result['expires'] = $future->getTimeStamp();

        //$token = JWT::encode(['id' => $user->id, 'email' => $user->email, 'regist_day' => $user->regist_day], $settings['secret'], "HS256");


        //return $this->response->withJson(['token' => $token]);
        $db = null;
        $resultData = array('result' => '200', 'message' => '', 'data' => $result);
        return $response
            ->withHeader('Location','/cook/api/abouts')
            ->withStatus(200)
            //->getBody()
            ->write(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

    }catch(CookException $e){
        throw $e;
    }catch(Exception $e){
        //$data = array('result' => '500', 'message' => 'Exception!', 'data' => '');
        $resultData = array('result' => '500', 'message' => '', 'data' => '{"error" : {"text" : '.$e->getMessage().'}}');
        throw new CookException(json_encode($resultData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

    }
});

?>