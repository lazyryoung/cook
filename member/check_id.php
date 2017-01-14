<meta charset="utf-8">
<?
echo $aaa.".......";
if(!$id)
{
   echo("아이디를 입력하세요.");
}
else
{
   include "../lib/dbconn.php";

   $sql = "select * from cook_member where id='$id' ";

   $result = mysqli_query($conn,$sql);
   $num_record = mysqli_num_rows($result);

   if ($num_record)
   {
      echo "아이디가 중복됩니다!<br>";
      echo "다른 아이디를 사용하세요.<br>";
   }
   else
   {
      echo "사용가능한 아이디입니다.";
   }

   mysqli_close($conn);
}
?>

