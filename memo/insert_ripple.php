<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-06-28
 * Time: 오후 9:42
 */
session_start();
?>
<meta charset="utf-8">
<?
if(!$userid){
    echo ("
    <script>
    window.alert('로그인 후 이용하세요.')
    history.go(-1)
    </script>
    ");
    exit;
}

if(!ripple_content){
    echo ("
    <script>
    window.alert('내용을 입력하세요');
    history.go(-1);
    </script>
    ");
    exit;
}

include "../lib/dbconn.php";

$sql="select * from member where id='$userid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);

$name=$row[name];
$nick=$row[nick];

$regist_day=date("Y-m-d(H-i)"); //현재시간 저장
//덧글 삽입 명령
    $sql="insert into memo_ripple(parent,id,name,nick,content,regist_day)
values ($num, '$userid','$name','$nick','$ripple_content','$regist_day')";

mysqli_query($conn,$sql);
mysqli_close($conn);

echo "
<script>
location.href='memo.php';
</script>
";
?>

