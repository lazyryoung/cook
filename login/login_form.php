<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta charset="utf-8">
	<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
	<link href="../css/member.css" rel="stylesheet" type="text/css" media="all">

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
					<form id="member_form" method="post" action="login.php">
						<div id="title">
							<img src="../img/title_login.gif">
						</div>
						<div id="login_form">
							<img src="../img/login_msg.gif">
							<div class="clear"></div>

							<div id="login1">
								<img src="../img/login_key.gif">
							</div>
							<div id="login2">
								<div id="id_input_button">
									<div id="id_pw_title">
										<ul>
											<li><img src="../img/id_title.gif"></li>
											<li><img src="../img/pw_title.gif"></li>
										</ul>
									</div>
									<div id="id_pw_input">
										<ul>
											<li><input type="text" name="id" class="login_input"></li>
											<li><input type="password" name="password" class="login_input"></li>
										</ul>
									</div>
									<div id="login_button">
										<input type="image" src="../img/login_button.gif">
									</div>
								</div>

								<div class="clear"></div>
								<div id="login_line"></div>
								<div id="join_button">
									<img src="../img/no_join.gif">&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="../member/member_form.php"><img src="../img/join_button.gif"</a>
								</div>
							</div>
						</div>
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






