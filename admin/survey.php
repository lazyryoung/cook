<? session_start() ?>
<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-07-11
 * Time: 오후 3:23
 */

include "../lib/dbconn.php";

$sql = "select * from cook_survey";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$sub1 = $row["sub1"];
$sub2 = $row["sub2"];
$sub3 = $row["sub3"];
$sub4 = $row["sub4"];




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


?>
<doctype="html">
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>
        관리자페이지
    </title>


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
                        <h3 class="box-title">설문 등록</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div id="form1">

                        <form class="form-signin" method="POST" action="survey_insert.php" id="form">

                            <h4 class="form-signin-heading"><span class="label label-danger">Insert Survey</span></h4>





                            <div class="form-group has-warning">

                                <input type="text" class="form-control" name="sub1" placeholder="<?= $sub1 ?>" required
                                       autofocus/>

                            </div>
                            <div class="form-group has-success">

                                <input id="inputWarning" type="text" class="form-control search-query" name="sub2" placeholder="<?= $sub2 ?>" required/>
                            </div>
                            <div class="form-group has-warning">

                                <input type="text" class="form-control" name="sub3" placeholder="<?= $sub3 ?>" required/>

                            </div>
                            <div class="form-group has-success">

                                <input type="text" class="form-control" name="sub4" placeholder="<?= $sub4 ?>" required/>
                            </div>










                            <button id="btn1" class="btn btn-lg btn-danger btn-block" type="submit">등록</button>
                        </form>
                        </div>
                        <div id="chart20">
                            <div id="chart21">
                            <div class="chart_sub"><h5><span class="label label-primary">Survey Result</span></h5></div>
                            <canvas id="myChart20" width="350" height="180"></canvas>
                            <canvas id="myChart30" width="350" height="150"></canvas>
                            </div>
                        </div>

                    </div><!-- /.box-body -->





.

                    <div id="backbtn2">
                        <input class="btn btn-primary " type="button" onclick="history.back()" value="관리자 페이지로"/>
                    </div>


                </div><!-- /.box -->



            </div> <!-- end of content -->
        </div>
    </div>








    <div id="footer0">
        <div id="footer1">

        </div>
    </div>
</div>



</body>
</html>
<script>
    var countries = document.getElementById("myChart20").getContext("2d");
    var pieData =
        [
            {
                label: "<?=$sub1?>",
                value: <?=$row1?>,
                color: "rgba(247,70,74,0.4)"

            },
            {
                label: "<?=$sub2?>",
                value: <?=$row2?>,
                color: "rgba(151,187,205,0.8)"


            },
            {
                label: "<?=$sub3?>",
                value: <?=$row3?>,
                color: "rgba(253,180,92,0.6)"
            },
            {
                label: "<?=$sub4?>",
                value: <?=$row4?>,
                color: "rgba(70,191,189,0.7)"
            }
        ];

    var pieOptions = {
        segmentShowStroke: true,
        animationSteps: 70,
        animateScale: false
    };
    new Chart(countries).Doughnut(pieData, pieOptions);

</script>
<script>
    var data = {
        labels: ["   <?=$sub4?>", "<?=$sub3?>", "<?=$sub2?>", "<?=$sub1?>"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(247,70,74,0.4)",
                strokeColor: "rgba(150,200,250,0.5)",
//                highlightFill: "rgba(150,200,250,0.75)",
                highlightFill: "#878BB6",
                highlightStroke: "rgba(150,200,250,0.5)",
                data: [<?=$row4?>, <?= $row3 ?>, <?= $row2 ?>, <?= $row1 ?>]
            }
        ]
    };
    var options = {
        animation: true,
        animationSteps: 200
    };
    var ctx = $('#myChart30').get(0).getContext('2d');
    window.barFill = new Chart(ctx).HorizontalBar(data, options);
    barFill.datasets[0].bars[0].fillColor = "rgba(70,191,189,0.7)";
    barFill.datasets[0].bars[1].fillColor = "rgba(253,180,92,0.6)";
    barFill.datasets[0].bars[2].fillColor = "rgba(151,187,205,0.8)";
    barFill.update();

</script>