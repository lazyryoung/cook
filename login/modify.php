<?
session_start();
?>
<meta charset="UTF-8">
<?
$hp=$hp1."-".$hp2."-"."$hp3";
$email=$email1."@".$email2;
$regist_day=date("Y-m-d(H:i)"); //현재날짜 년월일시분 저장

   include"../lib/dbconn.php";

$sql="update cook_member set password='$password' , name='$name', nick='$nick', hp='$hp', email='$email', regist_day='$regist_day' where id='$userid'";

mysqli_query($conn,$sql);
mysqli_close($conn);




echo("
<script>
//location.href='../index.php';
alert('수정이 완료되었습니다. 다시 로그인 해주세요.');
</script>
");

include "logout.php";


?>