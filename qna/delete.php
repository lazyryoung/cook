<?
session_start();

include "../lib/dbconn.php";

$sql = "delete from $table where num = $num";
mysqli_query($conn,$sql);

mysqli_close($conn);

echo "
	   <script>
	    location.href = 'list.php?table=$table';
	   </script>
	";
?>

