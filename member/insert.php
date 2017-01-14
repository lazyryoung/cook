<meta charset="utf-8">
<?
$hp = $hp1."-".$hp2."-".$hp3;
$email = $email1."@".$email2;

$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
$ip = $REMOTE_ADDR;         // 방문자의 IP 주소를 저장

include "../lib/dbconn.php";       // dconn.php 파일을 불러옴

$sql = "select * from cook_member where id='$id'";
$result = mysqli_query($conn,$sql);
$exist_id = mysqli_num_rows($result);

if($exist_id) {
   echo("
           <script>
             window.alert('해당 아이디가 존재합니다.')
             history.go(-1)
           </script>
         ");
   exit;
}
else
{            // 레코드 삽입 명령을 $sql에 입력
   $sql = "insert into cook_member(id, password, name, nick, hp, email, regist_day, level) ";
   $sql .= "values('$id', '$password', '$name', '$nick', '$hp', '$email', '$regist_day', 9)";

   $result2=mysqli_query($conn, $sql);  // $sql 에 저장된 명령 실행
   if(!$result2){
      echo " <script>alert('db저장실패!!')</script>";
   }
   else{
      echo "<script>alert('db저장성공!!')</script>";
   }
}

mysqli_close($conn);                // DB 연결 끊기
echo "
	   <script>
	    location.href = '../index.php';
	   </script>
	";

?>

   
