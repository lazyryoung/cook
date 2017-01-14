<?php
/**
 * Created by PhpStorm.
 * User: sedan
 * Date: 2016-06-17
 * Time: 오후 8:03
 */
session_start();

$scale = 5; //한 화면에 표시되는 글의 개수
include "../lib/dbconn.php";

$sql = "select * from memo order by num desc";
$result = mysqli_query($conn, $sql);
$total_record = mysqli_num_rows($result);

if ($total_record % $scale == 0) {
    $total_page = floor($total_record / $scale);
} else {
    $total_page = floor($total_record / $scale) + 1;
}

if (!$page) {
    $page = 1;
}

//페이지 번호($page)에 따른 시작 레코드($start)계산
$start = ($page - 1) * $scale;
$number = $total_record - $start;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
    <link href="../css/memo.css" rel="stylesheet" type="text/css" media="all">
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
                            <? include "../lib/left_menu.php" ?>
                        </div>
                    </div>

                    <div id="col2">
                        <div id="title">
                            <img src="../img/title_memo.gif">
                        </div>

                        <div id="memo_row1">
                            <form name="memo_form" method="post" action="insert.php">
                                <div id="memo_writer"><span> <?= $usernick ?></span></div>
                                <div id="memo1"><textarea rows="6" cols="95" name="content"></textarea></div>
                                <div id="memo2"><input type="image" src="../img/memo_button.gif"></div>
                            </form>
                        </div> <!-- end of memo_row1-->
                        <?
                        for ($i = $start;    $i < $start + $scale && $i < $total_record;       $i++)
                        {
                        mysqli_data_seek($result, $i);
                        $row = mysqli_fetch_array($result);

                        $memo_id = $row[id];
                        $memo_num = $row[num];
                        $memo_date = $row[regist_day];
                        $memo_nick = $row[nick];

                        $memo_content = str_replace("\n", "<br>", $row[content]);
                        $memo_content = str_replace(" ", "&nbsp;", $memo_content);
                        ?>
                        <div id="memo_writer_title">
                            <ul>
                                <li id="writer_title1"><?= $number ?></li>
                                <li id="writer_title2"><?= $memo_nick ?></li>
                                <li id="writer_title3"><?= $memo_date ?></li>
                                <li id="writer_title4">
                                    <?
                                    if ($userid == "sedan" || $userid == $memo_id) {
                                        echo "<a href='delete.php?num=$memo_num'>[삭제]</a>";
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div><!-- end of memo_writer_title-->
                        <div id="memo_content"><?= $memo_content ?>
                        </div><!-- end of memo_content-->
                        <div id="ripple">
                            <div id="ripple1">덧글</div>
                            <div id="ripple2">
                                <?
                                $sql = "select*from memo_ripple where parent='$memo_num'";
                                $ripple_result = mysqli_query($conn,$sql);
                                while ($row_ripple = mysqli_fetch_array($ripple_result)) {
                                    $ripple_num = $row_ripple[num];
                                    $ripple_id = $row_ripple[id];
                                    $ripple_nick = $row_ripple[nick];
                                    $ripple_content = str_replace("\n", "<br>", $row_ripple[content]);
                                    $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
                                    $ripple_date = $row_ripple[regist_day];
                                    ?>
                                    <div id="ripple_title">
                                        <ul>
                                            <li><?= $ripple_nick

                                                ?>&nbsp;&nbsp;&nbsp; <?= $ripple_date

                                                ?></li>
                                            <li id="mdi_del">
                                                <? if ($userid == "admin" || $userid == $ripple_id)
                                                    echo "<a href='delete_ripple.php?num=$ripple_num'>삭제</a>"
                                                ?>
                                            </li>
                                        </ul>
                                    </div><!--end of ripple_title-->
                                    <div id="ripple_content">
                                        <?= $ripple_content ?></div>
                                    <?
                                } //while문 종료
                                ?>

                                <form name="ripple_form" method="post" action="insert_ripple.php">
                                    <input type="hidden" name="num" value="<?= $memo_num

                                    ?>"> <!--hidden으로 처리했지만 이때 $num이 생성됨.-->

                                    <div id="ripple_insert">
                                        <div id="ripple_textarea">
                                            <textarea rows="3" cols="80" name="ripple_content"></textarea>
                                        </div> <!--end of ripple_textarea-->
                                        <div id="ripple_button"><input type="image" src="../img/memo_ripple_button.png"></div>
                                    </div><!--end of ripple_insert-->
                                </form>
                            </div> <!--end of ripple2-->
                            <div class="clear"></div>
                            <div class="linespace_10"></div>
                            <?
                            $number--;
                            }//for문 종료
                            mysqli_close($conn);
                            ?>
                            <div id="page_num">◀이전 &nbsp;&nbsp;&nbsp;&nbsp;
                                <? //게시판 목록 하단에 페이지 번호 링크 출력
                                for ($i=1; $i <= $total_page; $i++) {
                                    if ($page == $i) {
                                        echo "<b>$i</b>&nbsp";
                                    } else {
                                        echo "<a href='memo.php?page=$i'>$i</a>&nbsp";
                                    }
                                }
                                ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;다음 ▶
                            </div> <!--end of page_num-->
                        </div> <!--end of ripple-->
                    </div> <!--end of col2-->

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
