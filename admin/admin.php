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
        function info(){
            location.href= "info.php"
        }
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


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">관리자페이지</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h4 class="table_h4"><img src="../img/sub_icon1.png"/><span class="table_sub">게시글 수</span></h4>

                        <table id="admin_table1" class="table table-bordered table-hover table-striped">
                            <tr>
                                <td>about</td>
                                <td>가입인사</td>
                                <td>낙서장</td>
                                <td>자유게시판</td>
                                <td>자료실</td>
                                <td>참여문의</td>
                            </tr>
                            <tr>
                                <td> <?= $about ?></td>
                                <td><?= $greet ?> </td>
                                <td><?= $memo ?></td>
                                <td><?= $free ?></td>
                                <td><?= $download ?></td>
                                <td><?= $qna ?></td>
                            </tr>
                            </table>


                    </div>


                    <!-- /.box-body -->
                    <div id="chart9">
                        <div class="chart_sub"><h5><span class="label label-primary">카테고리별 작성글 수</span></h5></div>
                        <canvas id="myChart1" width="500" height="450 "></canvas>
                    </div>
                    <div id="chart10">
                        <div class="chart_sub"><h5><span class="label label-primary">설문 결과</span></h5></div>
                        <canvas id="myChart2" width="360" height="270"></canvas>
                        <canvas id="myChart3" width="330" height="170"></canvas>
                    </div>

                    <table id="admin_table2" class="table table-bordered table-hover table-striped">
                        <tr>
                            <td colspan="3">회원수</td>
                            <td >회원 현황</td>
                            <td >서버 정보</td>
                            <td >설문 조사</td>
                        </tr>
                        <tr>
                            <td colspan="3"><?= $member ?></td>
                            <td ><input class="btn btn-danger" type="button" value="보기"
                                        onclick="member()"/></td>
                            <td ><input class="btn btn-danger" type="button" value="보기"
                                        onclick="info()"/></td>

                            <td ><input class="btn btn-danger" type="button" value="등록"
                                        onclick="survey()"/></td>
                        </tr>
                    </table>


                    <div id="chart11">
                        <div class="chart_sub"><h5><span class="label label-primary">일자별 가입자 수</span></h5></div>
                        <canvas id="myChart4" width="840" height="400"></canvas>
                    </div>
.
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
    var data = {
        labels: ["about", "가입인사", "낙서장", "자유게시판", "자료실", "참여문의"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(150,200,250,0.5)",
                strokeColor: "rgba(150,200,250,0.8)",
                highlightFill: "rgba(150,200,250,0.75)",
                highlightStroke: "rgba(150,200,250,1)",
                data: [<?= $about ?>, <?= $greet ?>, <?= $memo ?>, <?= $free ?>, <?= $download ?>, <?= $qna ?>]
            }
        ]
    };
    var options = {
        animation: true,
        animationSteps: 200
    };
    var ctx = $('#myChart1').get(0).getContext('2d');
    var myBarChart = new Chart(ctx).Bar(data, options);


</script>
<script>
    var countries = document.getElementById("myChart2").getContext("2d");
    var pieData =
        [
            {
                label: "<?=$sub1?>",
                value: <?=$row1?>,
                color: "#878BB6",

            },
            {
                label: "<?=$sub2?>",
                value: <?=$row2?>,
                color: "#4ACAB4"
            },
            {
                label: "<?=$sub3?>",
                value: <?=$row3?>,
                color: "#FF8153"
            },
            {
                label: "<?=$sub4?>",
                value: <?=$row4?>,
                color: "#FFEA88"
            }
        ];

    var pieOptions = {
        segmentShowStroke: true,
        animationSteps: 70,
        animateScale: false
    }
    new Chart(countries).Pie(pieData, pieOptions);

</script>
<script>
    var data = {
        labels: ["   <?=$sub4?>", "<?=$sub3?>", "<?=$sub2?>", "<?=$sub1?>"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "#878BB6",
                strokeColor: "rgba(150,200,250,0.5)",
//                highlightFill: "rgba(150,200,250,0.75)",
                highlightFill: "#FF6384",
                highlightStroke: "rgba(150,200,250,0.5)",
                data: [<?=$row4?>, <?= $row3 ?>, <?= $row2 ?>, <?= $row1 ?>]
            }
        ]
    };
    var options = {
        animation: true,
        animationSteps: 200
    };
    var ctx = $('#myChart3').get(0).getContext('2d');
    window.barFill = new Chart(ctx).HorizontalBar(data, options);
    barFill.datasets[0].bars[0].fillColor = "#FFEA88";
    barFill.datasets[0].bars[1].fillColor = "#FF8153";
    barFill.datasets[0].bars[2].fillColor = "#4ACAB4";
    barFill.update();

</script>
<script>
    var array1 = new Array("<?=implode("\",\"" , $day_arr);?>");
    var array2 = new Array("<?=implode("\",\"", $day_cnt_arr);?>");

    var buyerData;
    buyerData = {

        labels: array1,
        datasets: [
            {
                fillColor: "rgba(172,194,132,0.4)",
                strokeColor: "#ACC26D",
                pointColor: "#fff",
                pointStrokeColor: "#9DB86D",
                data: array2
            }
        ]
    };

    // get line chart canvas
    var buyers = document.getElementById('myChart4').getContext('2d');
    var lineOptions = {

        animationSteps: 200,

    }
    // draw line chart
    new Chart(buyers).Line(buyerData, lineOptions);
</script>



