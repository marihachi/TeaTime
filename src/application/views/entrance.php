<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang=jp>
	<head>
		<meta charset=UTF-8 />
		<meta http-equiv=X-UA-Compatible content="IE=edge" />
		<meta name=viewport content="width=device-width, initial-scale=1" />
		<title>TeaTime | ティータイムにピッタリなSNS</title>
		<link href=//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css rel=stylesheet />
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src=//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js></script>
		<script src=//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js></script>
		<style>
			body {
				background: #D59B6D;
			}
			header, main, footer {
				margin: 0 auto;
				width: 800px;	
			}
			header {
			}
			main {
			}
			footer {
				text-align: center;
				padding: 10px;
			}
			.form-control {
				background-color: rgba(255, 255, 255, 0.8);
			}
		</style>
	</head>
	<body>
		<header>
			<h1>TeaTimeへようこそ</h1>
		</header>
		<main>
			<nav>
				<p>ログインもしくは<a href=/tea-time/new-account>サインアップ</a>してください。</p>
				<p>現在TeaTimeは運用に向けて開発中です。お待ちください。</p>
			</nav>
			<div id=login-box>
				<form>
					<div class=input-group>
						<span class=input-group-addon>ユーザー名</span>
						<input type=text class=form-control>
					</div>
					<div class=input-group>
						<span class=input-group-addon>パスワード</span>
						<input type=password class=form-control>
						<span class=input-group-btn>
							<input id=login-button class="btn btn-primary" type=submit value="ログイン">
						</span>
					</div>
				</form>
			</div>
		</main>
		<footer>
			<small>(c)2015 TeaTime.</small>
		</footer>
	</body>
</html>