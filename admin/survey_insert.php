<?session_start()?>
<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-07-11
 * Time: 오후 3:23
 */

include "../lib/dbconn.php";

$sql="update cook_survey set sub1 = '$sub1' ,ans1=0, sub2='$sub2' ,ans2=0, sub3='$sub3',ans3=0, sub4='$sub4',ans4=0";
//$sql="update survey set  '$sub1' ,0, '$sub2',0 , '$sub3',0,'$sub4'";
$result=mysqli_query($conn,$sql);

mysqli_close($conn);


echo "
	   <script>
	    location.href = 'survey.php';
	   </script>
	";

?>