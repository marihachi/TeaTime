<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>新しいアカウントを作成 - TeaTime</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script>
			$(function() {
				$('#account-create-form').submit(function(event) {
					event.preventDefault();
					$.ajax("api/web/account/create", {
						type: 'post',
						data: $(this).serialize(),
						dataType: 'json',
						xhrFields: {
							withCredentials: true
						}
					}).done(function(){
						location.href = "<?=$this->config->base_url();?>";
					}).fail(function(){
						$("#message").text("サインアップに失敗しました。入力情報を確認してください。");
					});
				});
			});
		</script>
		<style>
			body * {
				box-sizing: border-box;
			}
			body {
				background: #D59B6D;
				color: #fff;
				background: url("bg002.jpg");
				background-position: center center;
				background-size: cover;
				background-repeat: no-repeat;
				background-attachment: fixed;
			}
			main {
				text-align: center;
				display: flex;
			}
			main > section {
				background-color: rgba(255, 173, 67, 0.62);
				margin: 10px;
				padding: 20px;
				border-radius: 5px;
				color: #fff;
			}
			#account-create-section {
				margin: 0 auto;
				width: 500px;
			}
			#account-create-form {
				margin: 0 auto;
				width: 400px;
			}
			#account-create-form > label {
				display: block;
				margin: 10px 0px;
			}
			#account-create-form input, #account-create-form textarea {
				color: rgba(255, 255, 255, 1);
				border: 1px solid rgba(255, 255, 255, 1);
				background-color: transparent;
			}
			
			#account-create-form > label > input, #account-create-form > label > textarea {
				padding: 8px;
				width: 100%;
				resize: vertical;
			}
			#account-create-form > div {
				text-align: right;
			}
			#account-create-form > div > input {
				width: 100px;
				height: 35px;
			}
			#account-create-form > div > input:hover {
				background-color: rgba(255, 255, 255, .4);
			}
		</style>
	</head>
	<body>
		<main>
			<section id="account-create-section">
				<h1>さあTeaTimeをはじめましょう</h1>
				<form id="account-create-form">
					<label>
						<input type="text" placeholder="ユーザー名" name="screen_name">
					</label>
					<label>
						<input type="password" placeholder="パスワード" name="password">
					</label>
					<label>
						<input type="text" placeholder="名前" name="name">
					</label>
					<label>
						<textarea placeholder="プロフィール" name="bio"></textarea>
					</label>
					<div>
						<input type="submit" value="登録">
					</div>
				</form>
				<span id="message"></span>
				<p><a href="<?=$this->config->base_url();?>">エントランスへ</a></p>
			</section>
		</main>
	</body>
</html>