<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang=jp>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>TeaTime</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script>
			$(function() {
				$('#login-form').submit(function(event) {
					event.preventDefault();
					$.ajax("api/web/account/login", {
						type: 'post',
						data: $(this).serialize(),
						dataType: 'json',
						xhrFields: {
							withCredentials: true
						}
					}).done(function(){
						location.href = "<?=$this->config->base_url();?>";
					}).fail(function(){
						$('#login-message').text("ログインに失敗しました");
					});
				});
			});
		</script>
		<style>
			<?php
				$orange1 = "#FF9A00";
				$orange2 = "#FFAD33";
			?>
			* {
				font-family: "Hiragino Kaku Gothic ProN","ヒラギノ角ゴ ProN W3","Meiryo UI","Meiryo, メイリオ","sans-serif";
			}
			.jumbotron {
				background: url("bg002.jpg");
				background-position: center center;
				background-size: cover;
				background-repeat: no-repeat;
				background-attachment: fixed;
			}
			a {
				color: rgb(255, 100, 242);
			}
			a:focus {
				outline: thin dotted;
				outline-offset: -2px;
			}
			a:focus, a:hover {
				color: rgb(255, 155, 247);
				text-decoration: underline;
			}
			footer {
				text-align: center;
				padding: 10px;
			}
			footer small {
				color: #AAA;
			}
			.form-control {
				color: #555;
				background-color: rgba(255, 255, 255, 0.6);
				box-shadow: none;
			}
			.form-control:focus {
				border-color: <?= $orange1?>;
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 8px rgba(251, 152, 0, 0.6);
			}
			.btn-orange {
				color: #FFF;
				background-color: <?= $orange2?>;
				border-color: <?= $orange1?>;
				padding: 7px 20px;
			}
			.btn-orange:focus, .btn-orange:active, .btn-orange:hover {
				color: #EEE;
				outline: none !important;
			}
			#main-article, #login-box {
				background-color: rgba(255, 173, 67, 0.62);
				margin: 10px;
				padding: 20px;
				border-radius: 5px;
				color: #fff;
			}
		</style>
	</head>
	<body class="container jumbotron">
		<main class="row">
			<header>
			</header>
			<div class="col-md-8">
				<article id="main-article" class="container">
					<h1>TeaTimeへようこそ</h1>
					<p>ログインもしくは<a href=/tea-time/signup>サインアップ</a>してください。</p>
					<p>現在TeaTimeは運用に向けてオープンテスト中です。良かったらアカウント作ってね</p>
				</article>
			</div>
			<div class="col-md-4">
				<div id="login-box" class="container">
					<form id="login-form">
						<div class="form-group">
							<label class="control-label" for="username-box">ユーザー名</label>
							<input type="text" class="form-control" id="username-box" name="screen_name">
						</div>
						<div class="form-group">
							<label class="control-label" for="password-box">パスワード</label>
							<input type="password" class="form-control" id="password-box" name="password">
						</div>
						<label id="login-message"></label>
						<input id="login-button" class="btn btn-orange" type=submit value="ログイン">
					</form>
				</div>
			</div>
		</main>
		<footer>
			<small>(c)TeaTime.</small>
		</footer>
	</body>
</html>