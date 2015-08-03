<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8 />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>TeaTime | ティータイムにピッタリなSNS</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js" />
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" />
		<![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" />
		<style>
			body {
				padding: 0;
				margin: 0;
				text-align: center;
				background: #D59B6D;
				/*color: #fff;*/
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
					<div class="input-group">
						<span class="input-group-addon">ユーザー名</span>
						<input type=text class=form-control>
					</div>
					<div class="input-group">
						<span class="input-group-addon">パスワード</span>
						<input type=password class=form-control>
						<span class="input-group-btn">
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