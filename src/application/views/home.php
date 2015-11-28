<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<meta http-equiv=X-UA-Compatible content="IE=edge" />
		<meta name=viewport content="width=device-width, initial-scale=1" />
		<title>ホーム - TeaTime | ティータイムにピッタリなSNS</title>
		<script src=//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js></script>
		<script>
			$(function() {
				// logout
				$('#logout-button').click(function() {
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/account/logout", {
						type: 'get',
						dataType: 'json'
					}).done(function() {
						location.href = "http://marihachi.php.xdomain.jp/tea-time/";
					}).fail(function() {
						$('#logout-message').text('ログアウトに失敗しました');
					});
				});
				// status-update
				$('.home-postbar > form').submit(function(event) {
					event.preventDefault();
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/status/update", {
						type: 'post',
						dataType: 'json',
						data: {"text": $('.home-postbar > form > textarea').val()}
					}).done(function() {
						alert('投稿成功');
					}).fail(function() {
						alert('投稿に失敗しました');
					});
				});
			});
		</script>
		<style>
			* {
				box-sizing: border-box;
				color: rgba(0, 0, 0, 0.7);
				margin: 0;
				padding: 0;
			}
			main {
				display: block;
			}
			a , a:active, a:focus {
				color: rgba(255,255,255, 0.7);
				text-decoration: none;
			}
			a:hover {
				color: rgba(255,255,255, 0.9);
			}
			body {
				background-color: rgba(235, 217, 207, 1);
			}
			body > main {
				padding-left: 200px;
			}
			.home-sidebar {
				background-color: rgb(209, 170, 147);
				width: 200px;
				height: 100%;
				padding: 20px 0;
				position: fixed;
				top: 0;
				left: 0;
			}
			.home-sidebar > ul > li > a {
				display: flex;
				align-items: center;
				justify-content: flex-start;
				height: 50px;
				padding: 0px 35px;
				font-size: 16px;
			}
			.home-postbar {
				background-color: rgba(245, 236, 231, .9);
				width: 100%;
				position: fixed;
				bottom: 0;
			}
			.home-postbar > form {
				display: flex;
				justify-content: space-between;
			}
			.home-postbar > form > textarea {
				border: 0;
				padding: 5px;
				background-color: transparent;
				width: 100%;
				height: 100px;
				resize: none;
			}
			.home-postbar > form > input[type=submit] {
				border: 1px solid rgb(209, 170, 147);
				background-color: transparent;
				width: 60px;
			}
			.entry {
				display: flex;
				background-color: rgba(255, 255, 255, .2);
				margin: 10px;
				padding: 10px 0px;
			}
			.entry > .user-icon {
				height: 64px;
				width: 64px;
				margin: 0px 15px;
			}
			.entry > div > header {
				display: flex;
				align-items: baseline;
			}
			.entry > div > header > h1 {
				font-size: 20px;
				font-weight: 400;
			}
			.entry > div > header > h2 {
				font-size: 16px;
				font-weight: 400;
				color: rgba(0, 0, 0, 0.5);
			}
			.entry > div > header > h2:before {
				content: "(@";
				margin-left: 5px;
			}
			.entry > div > header > h2:after {
				content: ")";
			}
			.entry > div > p {
				
			}
		</style>
	</head>
	<body>
		<aside class="home-sidebar">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Mention</a></li>
			</ul>
		</aside>
		<main>
			<ol class="timeline">
				<li>
					<article class="entry">
						<img class="user-icon" src="/tea-time/icon_test.jpg">
						<div>
							<header>
								<h1>Test</h1>
								<h2>ScreenName</h2>
							</header>
							<p>Home is in preparation.</p>
						</div>
					</article>
				</li>
			</ol>
		</main>
		<footer class="home-postbar">
			<form>
				<textarea placeholder="ここに投稿内容を入力します"></textarea>
				<input type="submit" value="Post">
			</form>
		</footer>
	</body>
</html>