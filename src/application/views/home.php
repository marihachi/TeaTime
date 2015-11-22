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
				// logout
				$('#logout-button').click(function() {
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/account/logout", {
						type: 'get',
						dataType: 'json',
					}).done(function() {
						location.href = "http://marihachi.php.xdomain.jp/tea-time/";
					}).fail(function() {
						$('#logout-message').text('ログアウトに失敗しました');
					});
				});
				
				// status-update
				$('#post-button').click(function() {
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/status/update", {
						type: 'post',
						dataType: 'json',
					}).done(function() {
						alert('投稿成功');
					}).fail(function() {
						alert('投稿に失敗しました');
					});
				});
			});
		</script>
		<style>
			a {
				color: #fff;
			}
			a:active, a:hover, a:focus {
				color: #ddd;
			}
			.jumbotron {
				color: #333;
				padding-top: 94px;
				
				background: url("/tea-time/bg002.jpg");
				background-position: center center;
				background-size: cover;
				background-repeat: no-repeat;
				background-attachment: fixed;
			}
			.home-nav .btn-teatime-white {
				background: transparent;
				border: 1px solid #fff;
				color: #fff;
				border: 2px solid rgb(255, 255, 255);
				margin: 6px 0;
			}
			.btn-teatime-1:hover,
			.btn-teatime-1:active,
			.btn-teatime-1:focus{
				color: #eee;
				outline: none;
			}
			
			.home-nav {
				position: fixed;
				top: 0px;
				right: 0px;
				left: 0px;
				z-index: 1030;
				color: #fff;
				background: #D59B6D;
				background-color: rgba(255, 173, 67, 0.62);
			}
			.home-nav a.item {
				display: block;
				font-size: 16px;
				padding: 12px;
				text-align: center;
			}
			.home-nav input.form-control {
				color: #555;
				background-color: rgba(255, 255, 255, 0.6);
				box-shadow: none;
				border: 2px solid rgb(255, 255, 255);
				height: 36px;
				margin: 6px 0;
			}
			.home-nav input.form-control:focus {
				border-color: #FF9A00;
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 4px rgba(251, 152, 0, 0.6);
			}
			.no-padding-right {
				padding-right: 0;
			}
			.no-padding-left {
				padding-left: 0;
			}
			.entry {
				border: 2px solid white;
				border-radius: 5px;
				margin: 10px;
				padding: 10px;
				color: #fff;
				background-color: rgba(255, 173, 67, 0.62);
			}
			.entry img {
				height: 64px;
				width: 64px;
			}
		</style>
	</head>
	<body class=jumbotron>
		<nav class="home-nav">
			<div class=container>
				<div class=row>
					<div class="col-xs-4">
						<div class="col-xs-6 no-padding-right"><a href="#" class=item>Home</a></div>
						<div class="col-xs-6 no-padding-left"><a href="#" class=item>Mention</a></div>
					</div>
					<div class="col-xs-6">
						<div class=input-group>
							<input type=text class="form-control" id=post-text-box>
							<span class="input-group-btn">
								<button class="btn btn-teatime-white" id=post-button>Post</button>
							</span>
						</div>
					</div>
					<div class="col-xs-2">
						<button id=logout-button class="btn btn-teatime-white">ログアウト</button>
					</div>
				</div>
			</div>
		</nav>
		<main>
			<div class=container>
				<div class=row>
					<div class="entry col-xs-4">
						<img src="/tea-time/icon_test.jpg" />
						This is status sample.
					</div>
				</div>
				<div class=row>
					<div class="entry col-xs-4">
						<img src="/tea-time/icon_test.jpg" />
						This is status sample.
					</div>
				</div>
			</div>
		</main>
	</body>
</html>