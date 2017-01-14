<? session_start() ?>
<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-07-11
 * Time: 오후 3:23
 */
include "../lib/dbconn.php";
$sql = "select * from cook_about";
$result = mysqli_query($conn, $sql);
$about = mysqli_num_rows($result);

$sql = "select * from cook_greet";
$result = mysqli_query($conn, $sql);
$greet = mysqli_num_rows($result);

$sql = "select * from cook_memo";
$result = mysqli_query($conn, $sql);
$memo = mysqli_num_rows($result);

$sql = "select * from cook_free";
$result = mysqli_query($conn, $sql);
$free = mysqli_num_rows($result);

$sql = "select * from cook_download";
$result = mysqli_query($conn, $sql);
$download = mysqli_num_rows($result);

$sql = "select * from cook_qna";
$result = mysqli_query($conn, $sql);
$qna = mysqli_num_rows($result);

$sql = "select * from cook_member";
$result = mysqli_query($conn, $sql);
$member = mysqli_num_rows($result);

$sql = "select * from cook_survey";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$total = $row[ans1] + $row[ans2] + $row[ans3] + $row[ans4];

$row1 = $row[ans1];
$row2 = $row[ans2];
$row3 = $row[ans3];
$row4 = $row[ans4];

if (0 == $row[ans1]) {
    $ans1_percent = 0;
} else {
    $ans1_percent = $row[ans1] / $total * 100;
    $ans1_percent = floor($ans1_percent);
}
if (0 == $row[ans2]) {
    $ans2_percent = 0;
} else {
    $ans2_percent = $row[ans2] / $total * 100;
    $ans2_percent = floor($ans2_percent);
}
if (0 == $row[ans3]) {
    $ans3_percent = 0;
} else {
    $ans3_percent = $row[ans3] / $total * 100;
    $ans3_percent = floor($ans3_percent);
}
if (0 == $row[ans4]) {
    $ans4_percent = 0;
} else {
    $ans4_percent = $row[ans4] / $total * 100;
    $ans4_percent = floor($ans4_percent);
}

$sql = "select * from cook_survey";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$sub1 = $row["sub1"];
$sub2 = $row["sub2"];
$sub3 = $row["sub3"];
$sub4 = $row["sub4"];


$sql = "select regist_day from cook_member";
$result = mysqli_query($conn, $sql);
$day_rows = mysqli_num_rows($result);

//날짜
$yesterday = "";
//가입인원수
$day_cnt = 0;
//배열번호
$arr_num = 0;

for ($i = 0; $i < $day_rows; $i++) {
    $row = mysqli_fetch_array($result);
    //for문 돌때마다 날짜를 대입
    $day = $row[regist_day];

//맨처음은 $yesterday가 공백 이므로 $day와 같지 않다.
    if ($yesterday != $day) {
        if ($yesterday == "") {
            //맨처음은 $yesterday가 공백 이므로 가입인원수 누적만 실행.
            $day_cnt++;
        } //for문을 돌았는데 $yesterday와 $day가 다르고 $yesterday가 공백도 아니면 else실행
        else {

            $day_arr[$arr_num] = $yesterday;
            $day_cnt_arr[$arr_num] = $day_cnt;
            $arr_num++;
            $day_cnt = 1;
        }
    } //$yesterday와 $day가 같으면 if실행
    else if ($yesterday == $day) {
        //for문 돌았는데 날짜가 같으면 가입인원수에 누적카운팅.
        $day_cnt++;
    }
//for문이 한번 roof하기 직전에 $yesterday에 $day를 대입.
    $yesterday = $day;
}
//for문 종료후 마지막 배열번호에 마지막 날짜와 가입인원수를 저장.
$day_arr[$arr_num] = $yesterday;
$day_cnt_arr[$arr_num] = $day_cnt;


//for ($i = 0; $i < count($day_arr); $i++) {
//    echo $day_arr[$i], "의 가입회원 수:", $day_cnt_arr[$i], "<br>";
//}

?>
<?

$sql = "   SELECT
                            table_schema,
                            round(SUM((data_length+index_length)/1024/1024),2) MB
                            FROM information_schema.tables
                            where table_schema = 'sedan'";

$result = mysqli_query($conn, $sql);
while ($arr = mysqli_fetch_array($result)) {
    $db_name = $arr[table_schema];
    $db_MB = $arr[MB];
}


?>
<!DOCTYPE html>
<!--suppress ALL -->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>관리자페이지</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../css/common.css" type="text/css" media="all">
    <link rel="stylesheet" href="../css/admin.css" type="text/css" media="all">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- jQuery 2.2.3 -->
    <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="../plugins/chartjs/Chart.js"></script>

    <script src="../plugins/chartjs/Chart.HorizontalBar.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>


    <script>
        function member() {
            location.href = "member_view.php";
        }
        function survey() {
            location.href = "survey.php";
        }
    </script>

    <style>

    </style>
</head>

<body>

<div id="container">
    <div id="header0">
        <div id="header1">
            <div id="header2">
                <div id="header3_1">
                    <? include "../lib/top_login2.php"; ?>
                </div>
                <div id="header3_2">
                    <? include "../lib/top_menu2.php"; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="content0">
        <div id="content1">

            <div id="content">

<!--                <style>-->
<!---->
<!--                    h4 {-->
<!---->
<!--                        color: #333333;-->
<!--                        font-weight: bold;-->
<!--                        margin-bottom: 5px;-->
<!--                        margin-left: 5px;-->
<!--                        font-size: 1.17em;-->
<!--                        -webkit-margin-before: 2em;-->
<!--                        -webkit-margin-after: 1em;-->
<!--                        -webkit-margin-start: 0px;-->
<!--                        -webkit-margin-end: 0px;-->
<!---->
<!--                    }-->
<!---->
<!--                    .table_sub {-->
<!--                        /*margin-left: 5px;*/-->
<!--                    }-->
<!---->
<!--                    .box-title {-->
<!--                        /*margin-bottom: 20px;*/-->
<!--                    }-->
<!--                </style>-->
                <div id="box2">
                    <div id="t1">
                    <div class="box-header">
                        <h3 class="box-title">서버 정보</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">


                        <h4 class="table_h4"><img src="../img/sub_icon1.png"/><span class="table_sub">서버 환경</span></h4>
                        <table id="info_table1" class="table table-bordered table-hover table-striped">
                            <tr class="sub_td">
                                <td>서버주소</td>
                                <td>시작일</td>
                                <td>서버DB명</td>
                                <td>DB사용량</td>
                                <td>언어셋</td>
                                <td>웹서버</td>
                                <td>PHP</td>
                                <td>MySQL</td>
                            </tr>
                            <tr>
                                <td>sedan.ivyro.net</td>
                                <td>2016-07-13</td>
                                <td><?= $db_name ?></td>
                                <td><?= $db_MB ?>&nbsp;MB</td>
                                <td>UTF-8</td>
                                <td>Apache 2.2.29</td>
                                <td>PHP 5.6</td>
                                <td>MySQL 5.6.23</td>
                            </tr>
                        </table>


                        <h4 class="table_h4"><img src="../img/sub_icon1.png"/><span class="table_sub">개발 환경</span></h4>
                        <table id="info_table2" class="table table-bordered table-hover table-striped">
                            <tr class="sub_td">
                                <td>jQuery</td>
                                <td>Bootstrap</td>
                                <td>DataTables</td>
                                <td>Chart.js</td>
                                <td>WordPress</td>
                                <td>PhpStorm</td>
                            </tr>
                            <tr>
                                <td>2.2.3</td>
                                <td>3.3.6</td>
                                <td>1.10.7</td>
                                <td>1.1.1</td>
                                <td>4.5.2</td>
                                <td>10.0.1</td>
                            </tr>
                        </table>

                        <h4 class="table_h4"><img src="../img/sub_icon1.png"/><span class="table_sub">테이블별 db사용량</span></h4>
                        <table id="info_table3" class="table table-bordered table-hover table-striped">
                            <tr class="sub_td">
                                <?
                                $sql = "SELECT
table_name,
round(((data_length+index_length)/1024),2) KB
FROM information_schema.TABLES
where table_schema = 'sedan'";

                                $result = mysqli_query($conn, $sql);
                                $td_cnt = 0;
                                $row = mysqli_num_rows($result);
                                for ($i = 0; $i < $row; $i++) {
                                    $arr = mysqli_fetch_array($result);

                                    $table_name[$i] = $arr[table_name];
                                    $table_KB[$i] = $arr[KB];
                                    $td_cnt++;
                                }
                                for ($i = 0; $i < 5; $i++) {
                                    echo "<td>" . $table_name[$i] . "</td>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <?
                                for ($i = 0; $i < 5; $i++) {
                                    echo "<td>" . $table_KB[$i] . "&nbsp;KB</td>";
                                }
                                ?>
                            </tr>
                            <tr class="sub_td">
                                <?
                                for ($i = 5; $i < 10; $i++) {
                                    echo "<td>" . $table_name[$i] . "</td>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <?
                                for ($i = 5; $i < 10; $i++) {
                                    echo "<td>" . $table_KB[$i] . "&nbsp;KB</td>";
                                }
                                ?>
                            </tr>
                        </table>

                    </div>


                    <!-- /.box-body -->


                    <div id="chart19">
                        <div class="chart_sub"><h5><span class="label label-primary">테이블별 db사용량 (단위:KB)</span></h5></div>
                        <canvas id="myChart11" width="840" height="250 "></canvas>
                    </div>






                        <div id="admin_go">
                            <input type="button" class="btn btn-primary" value="관리자 페이지로"
                                   onclick="location.href='admin.php'">
                        </div>

                    </div>
                </div>
                <!-- /.box -->











            </div> <!-- end of content -->
        </div><!-- end of content1 -->
    </div><!-- end of content0 -->
    <div id="footer0">
        <div id="footer1">

        </div>
    </div>
</div>


</body>
</html>
<script>
    var array1 = new Array("<?=implode("\",\"" , $table_name);?>");
    var array2 = new Array("<?=implode("\",\"" , $table_KB);?>");
    var data = {
        labels: array1,
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(255,99,132,0.2)",
                strokeColor: "rgba(255,99,132,0.4)",
                highlightFill: "rgba(255,99,132,0.5)",
                highlightStroke: "rgba(255,99,132,1)",
                data: array2
            }
        ]
    };
    var options = {
        animation: true,
        animationSteps: 100
    };
    var ctx = $('#myChart11').get(0).getContext('2d');
    var myBarChart = new Chart(ctx).Bar(data, options);


</script>