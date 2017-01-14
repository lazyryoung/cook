<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-06-28
 * Time: 오후 10:30
 */
include "../lib/dbconn.php";

$sql="delete from memo_ripple where num=$num";
mysqli_query($conn,$sql);
mysqli_close($conn);

echo "
<script>
location.href='memo.php'
</script>
"
?>
