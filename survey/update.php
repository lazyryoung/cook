<?
include "../lib/dbconn.php";

$sql = "update survey set $composer = $composer + 1";
mysqli_query($conn,$sql);

mysqli_close($conn);

echo "
	   <script>
	    location.href = 'result.php';
	   </script>
	";
?>

