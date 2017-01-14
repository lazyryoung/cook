<?
$conn=mysqli_connect('localhost','sedan','hurin0315','sedan');
if(!$conn){
    echo "접속실패!".mysqli_connect_error();
}else {
    echo "접속성공";}
?>



