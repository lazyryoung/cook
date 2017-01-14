<? session_start() ?>
<?
include "../lib/dbconn.php";

$sql = "select * from survey";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$total = $row[ans1] + $row[ans2] + $row[ans3] + $row[ans4];

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

<div id="result">
                    <table width=250 height=250 border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                            <td width=180 height=1 colspan=5 bgcolor=#ffffff></td>
                        </tr>
                        <tr>
                            <td width=1 height=35 bgcolor='#ffffff'></td>
                            <td width=9 bgcolor='#ffffff'></td>
                            <td width=150 bgcolor='#ffffff'><b>
                                    총 투표수 : <? echo $total ?> &nbsp;명 </b></td>
                            <td width=9 bgcolor='#ffffff'></td>
                            <td width=1 bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=29 bgcolor='#ffffff'></td>
                            <td></td>
                            <td valign=middle><b>가장 좋아하는 요리는?</b></td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=20 bgcolor='#ffffff'></td>
                            <td></td>
                            <td><?=$sub1?> (<b><? echo $ans1_percent ?></b> %)
                                <font color=purple><b><? echo $row[ans1] ?></b></font> 명
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=3 bgcolor='#ffffff'></td>
                            <td></td>
                            <td>
                                <table width=130 border=0 height=3 cellspacing=0 cellpadding=0>
                                    <tr>
                                        <?
                                        $rest = 100 - $ans1_percent;
                                        echo "
        <td width='$ans1_percent%' bgcolor=purple></td>
        <td width='$rest%' bgcolor='#dddddd' height=5></td>
               ";
                                        ?>
                                    </tr>
                                </table>
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=20 bgcolor='#ffffff'></td>
                            <td></td>
                            <td> <?=$sub2?> (<b><? echo $ans2_percent ?></b> %)
                                <font color=blue><b><? echo $row[ans2] ?></b></font> 명
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=3 bgcolor='#ffffff'></td>
                            <td></td>
                            <td>
                                <table width=130 border=0 height=3 cellspacing=0 cellpadding=0>
                                    <tr>
                                        <?
                                        $rest = 100 - $ans2_percent;
                                        echo "
        <td width='$ans2_percent%' bgcolor=blue></td>
        <td width='$rest%' bgcolor='#dddddd' height=5></td>
               ";
                                        ?>
                                    </tr>
                                </table>
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=20 bgcolor='#ffffff'></td>
                            <td></td>
                            <td> <?=$sub3?> (<b><? echo $ans3_percent ?></b> %)
                                <font color=green><b><? echo $row[ans3] ?></b></font> 명
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=3 bgcolor='#ffffff'></td>
                            <td></td>
                            <td>
                                <table width=130 border=0 height=3 cellspacing=0 cellpadding=0>
                                    <tr>
                                        <?
                                        $rest = 100 - $ans3_percent;
                                        echo "
          <td width='$ans3_percent%' bgcolor=green></td>
          <td width='$rest%' bgcolor='#dddddd' height=5></td>
               ";
                                        ?>
                                    </tr>
                                </table>
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>

                        <tr>
                            <td height=20 bgcolor='#ffffff'></td>
                            <td></td>
                            <td> <?=$sub4?> (<b><? echo $ans4_percent ?></b> %)
                                <font color=skyblue><b><? echo $row[ans4] ?></b></font> 명
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=3 bgcolor='#ffffff'></td>
                            <td></td>
                            <td>
                                <table width=130 border=0 height=3 cellspacing=0 cellpadding=0>
                                    <tr>
                                        <?
                                        $rest = 100 - $ans4_percent;
                                        echo "
          <td width='$ans4_percent%' bgcolor=skyblue></td>
          <td width='$rest%' bgcolor='#dddddd' height=5></td>
               ";
                                        ?>
                                    </tr>
                                </table>
                            </td>
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=40 bgcolor='#ffffff'></td>
                            <td></td>
                            <td align=center valign=middle>
                                <input type="button" value="이전으로" onclick="history.back()" style="cursor:pointer">
                                <!--                                <input type='image' style='cursor:hand' src='../img/close.gif' border=0  onfocus=this.blur() onclick="window.close()"></td>-->
                            <td></td>
                            <td bgcolor='#ffffff'></td>
                        </tr>
                        <tr>
                            <td height=1 colspan=5 bgcolor=#ffffff></td>
                        </tr>
                    </table>
</div>
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
