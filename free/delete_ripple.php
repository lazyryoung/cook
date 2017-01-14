<?
include "../lib/dbconn.php";

$sql = "delete from free_ripple where num=$ripple_num";
mysqli_query($conn,$sql);
mysqli_close($conn);

echo "
	   <script>
	    location.href = 'view.php?table=$table&num=$num';
	   </script>
	  ";
?>
