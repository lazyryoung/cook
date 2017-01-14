<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-06-28
 * Time: 오전 4:32
 */
session_start();?>
<meta charset="utf-8">
    <?
if(!$userid)
{
    echo ("
    <script>
    window.alert('로그인 후 이용해 주세요.')
    history.go(-1)
    </script>
    ");
    exit;
}

if(!$content)
{
    echo("
    <script>
    window.alert('내용을 입력하세요.')
    history.go(-1)
    </script>
    ");
    exit;
}

$regist_day=date("Y-m-d(H:i)");
include "../lib/dbconn.php";

$sql="select*from member where id='$userid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);

$name=$row[name];
$nick=$row[nick];

$sql="insert into memo(id,name, nick, content,regist_day)
values('$userid','$name','$nick','$content','$regist_day')";

mysqli_query($conn,$sql);
mysqli_close($conn);

echo ("
<script>

location.href='./memo.php';
</script>
");
?>