<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<title>新しいアカウントを作成 - TeaTime | ティータイムにピッタリなSNS</title>
		<style>
			body {
				background: #D59B6D;
				color: #fff;
			}
			main {
				margin: auto;
				position: absolute;
				top: 0px;
				right: 0px;
				bottom: 0px;
				left: 0px;
				height: 14em;
				text-align: center;
			}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>
			$(function() {
				$('#account-create-form').submit(function(event) {
					event.preventDefault();
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/account/generate.json", {
						type: 'post',
						data: $(this).serialize(),
						dataType: 'json',
						xhrFields: {
							withCredentials: true
						}
					}).done(function(){
						location.href = "http://marihachi.php.xdomain.jp/tea-time";
					}).fail(function(){

					});
				});
			});
		</script>
	</head>
	<body>
		<main>
			<form id="account-create-form">
				<input type="text" placeholder="ユーザー名" name="screen_name" />
				<input type="password" placeholder="パスワード" name="password" />
				<input type="text" placeholder="名前" name="name" />
				<input type="text" placeholder="プロフィール" name="bio" />
				<input type="submit" />
			</form>
			<p><a href=/tea-time>エントランスへ</a></p>
		</main>
	</body>
</html>