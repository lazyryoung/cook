<?
session_start();
include "../lib/dbconn.php";

$sql = "select * from cook_member";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);


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
    <link rel="stylesheet" href="../css/common.css"  type="text/css" media="all">
    <link rel="stylesheet" href="../css/admin.css"  type="text/css" media="all">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- jQuery 2.2.3 -->
    <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- page script -->
    <script>
        $(function () {

            $('#member_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false

            });
        });
    </script>
    <script>
        function member(){
            location.href="member_view.php";
        }
        function survey(){
            location.href="survey.php";
        }
    </script>

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
                                        <h3 class="box-title">회원 현황</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="member_table" class="table table-bordered table-hover table-striped" >
                                            <thead>

                                            <tr>

                                                <th>id</th>
                                                <th>name</th>
                                                <th>nick</th>
                                                <th>hp</th>
                                                <th>email</th>
                                                <th>regist_day</th>
                                                <th>level</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?

                                            for ($i = 0; $i < $num_rows; $i++) {
                                                $row = mysqli_fetch_array($result);


                                                echo "
<tr>
<td>$row[id]</td>
<td>$row[name]</td>
<td>$row[nick]</td>
<td>$row[hp]</td>
<td>$row[email]</td>
<td>$row[regist_day]</td>
<td>$row[level]</td></tr>
";
                                            }

                                            ?>


                                            </tbody>

                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                    <div id="backbtn">
                                        <input  class="btn btn-primary"type="button" onclick="history.back()" value="관리자 페이지로"/>
                                    </div>

                                    <!-- /.box-bottom -->
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







