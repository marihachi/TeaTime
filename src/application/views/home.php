<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<title>ホーム - TeaTime | ティータイムにピッタリなSNS</title>
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
						<input type=text id=TextLineBox></input>
						<input type=submit value=Post></input>
					</form>
				</li>
			</ul>
		</nav>
		<p>TeaTimeへようこそ</p>
		<p><a href=/user>ユーザーページへ</a></p>
	</body>
</html>