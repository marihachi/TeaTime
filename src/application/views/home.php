<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<meta http-equiv=X-UA-Compatible content="IE=edge" />
		<meta name=viewport content="width=device-width, initial-scale=1" />
		<title>ホーム - TeaTime | ティータイムにピッタリなSNS</title>
		<link href=//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css rel=stylesheet />
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src=//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js></script>
		<script src=//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js></script>
		<script>
			$(function() {
				// ログアウト
				$('#logout-form').submit(function(event) {
					event.preventDefault();
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/account/logout", {
						type: 'get',
						dataType: 'json',
						xhrFields: {
							withCredentials: true
						}
					}).done(function(){
						location.href = "http://marihachi.php.xdomain.jp/tea-time/";
					}).fail(function(){
						$('#logout-message').text("ログアウトに失敗しました。");
					});
				});
			});
		</script>
		<style>
			* {
				margin: 0;
				padding: 0;
			}
			body {
				background: #eee;
				color: #333;
			}
			nav#ToolBar {
				font-size: 20px;
				position: fixed;
				bottom: 0;
				height: 50px;
				width: 100%;
				color: #fff;
				background: #D59B6D;
				opacity: 0.92;
			}
			#ToolBar ul li {
				display: inline-block;
			}
		</style>
	</head>
	<body>
		<nav id=ToolBar>
			<ul>
				<li>TeaTime</li>
				<li>Home</li>
				<li>Mention</li>
				<li>
					<form>
						<input type=text id=TextLineBox>
						<input type=submit value=Post>
					</form>
				</li>
			</ul>
		</nav>
		<p>TeaTimeへようこそ <?= $name?>さん</p>
		<form id=logout-form>
			<input type=submit id=logout-button value="ログアウト">
			<label id=logout-message></label>
		</form>
	</body>
</html>