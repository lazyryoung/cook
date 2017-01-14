<?
session_start();
?>
<meta charset="UTF-8">
<?
//이전 화면에서 이름이 입력되지 않았으면 "이름을 입력하세요."
    //메세지 출력
if(!$id){
    echo ("
    <script>
    window.alert('아이디를 입력하세요.');
    history.go(-1);
    </script>
    ");
    exit;
}

if(!$password){
    echo("
    <script>
    window.alert('비밀번호를 입력하세요.');
    history.go(-1);
    </script>
    ");
    exit;
}
include "../lib/dbconn.php";

$sql="select *from cook_member where id='$id'";
$result=mysqli_query($conn,$sql);
$num_match=mysqli_num_rows($result);

if(!$num_match){
    echo ("
    <script>
    window.alert('등록되지 않은 아이디 입니다.');
    history.go(-1);
    </script>
    ");
}
else{
    $row=mysqli_fetch_array($result);
    $db_pass=$row[password];

    if($password!=$db_pass){
        echo("
        <script>
        window.alert('비밀번호가 틀립니다');
        history.go(-1);
        </script>
        ");
        exit;
    }
    else{
        $userid=$row[id];
        $username=$row[name];
        $usernick=$row[nick];
        $userlevel=$row[level];

        $_SESSION['userid']=$userid;
        $_SESSION['username']=$username;
        $_SESSION['usernick']=$usernick;
        $_SESSION['userlevel']=$userlevel;

        echo("
        <script>
        window.alert('로그인아이디:$userid');
        location.href='../index.php';
        </script>
        ");


    }
}

?>