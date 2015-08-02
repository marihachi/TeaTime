<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<title>TeaTime | ティータイムにピッタリなSNS</title>
		<style>
			.clear:after {
				content: "";
				display: block;
				clear: both;
			}
			
			body {
				padding: 0;
				margin: 0;
				text-align: center;
				background: #D59B6D;
				color: #fff;
			}
			header {
				
			}
			header h1 {
				font-size: 20px;
			}
			main {
				margin: 0 auto;
				width: 800px;
			}
			main nav {
				float: left;
			}
			#login-box {
				float: right;
			}
			#screen-name-box, #password-box {
				display: block;
				margin: 5px 0;
			}
			
			footer {
				
			}
		</style>
	</head>
	<body>
		<header>
			<h1>TeaTimeへようこそ</h1>
		</header>
		<main class=clear>
			<nav>
				<p>ログインもしくは<a href=/tea-time/new-account>サインアップ</a>してください。</p>
				<p>現在TeaTimeは運用に向けて開発中です。お待ちください。</p>
			</nav>
			<div id=login-box>
				<form>
					<input id=screen-name-box type=text placeholder="ユーザー名">
					<input id=password-box type=password placeholder="パスワード">
					<input id=login-button type=submit value="ログイン">
				</form>
			</div>
		</main>
		<footer>
			<small>(c)2015 TeaTime.</small>
		</footer>
	</body>
</html>