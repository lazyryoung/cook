<?session_start()?>
<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-07-11
 * Time: 오후 3:23
 */

include "../lib/dbconn.php";

$sql="select * from survey";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
$sub1=$row["sub1"];
$sub2=$row["sub2"];
$sub3=$row["sub3"];
$sub4=$row["sub4"];



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="utf-8">
    <link href="../css/common.css" rel="stylesheet" type="text/css" media="all">

    <link rel="stylesheet" href="../css/survey.css" type="text/css">
    <meta charset="utf-8">
    <script type="text/javascript">
        function update()
        {
            var vote;
            var length = document.survey_form.composer.length;

            for (var i=0; i<length; i++)
            {
                if (document.survey_form.composer[i].checked == true)
                {
                    vote= document.survey_form.composer[i].value;
                    break;
                }
            }

            if (i == length)
            {
                alert("문항을 선택하세요!");
                return;
            }

            location.href = "update.php?composer="+vote;

        }

    </script>

    <title> 설문조사 </title>
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
                <div id="col1">
                    <div id="left_menu">
                        <?
                        include "../lib/left_menu.php";
                        ?>
                    </div>
                </div>

                <div id="col2">
                    <form name=survey_form method=post id="form1">
                        <table border=0 cellspacing=0 cellpdding=0 width='200' align='center'>
                            <input type=hidden name=kkk value=100>
                            <tr height=40>
                                <td><img src="../img/bbs_poll.gif"></td>
                            </tr>
                            <tr height=1 bgcolor=#cccccc><td></td></tr>
                            <tr height=7><td></td></tr>
                            <tr><td><b>  가장 좋아하는 요리는?</b></td></tr>
                            <tr><td><input type=radio name='composer' value='ans1' >1. <?=$sub1?></td></tr>
                            <tr height=5><td></td></tr>
                            <tr><td><input type=radio name='composer' value='ans2' >2. <?=$sub2?></td></tr>
                            <tr height=5><td></td></tr>
                            <tr><td><input type=radio name='composer' value='ans3' >3. <?=$sub3?></td></tr>
                            <tr height=5><td></td></tr>
                            <tr><td><input type=radio name='composer' value='ans4' >4. <?=$sub4?></td></tr>
                            <tr height=7><td></td></tr>
                            <tr height=1 bgcolor=#cccccc><td></td></tr>
                            <tr>
                            <tr height=7><td></td></tr>
                            <tr>
                                <td align=middle>



                                    <img src="../img/b_vote.gif" onclick="update()" style="cursor: pointer">

                                    <img src="../img/b_result.gif" onclick="location.href='result.php'" style="cursor:pointer"></a>
                                    </td></tr>
                        </table>
                    </form>


                </div> <!-- end of col2 -->

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
