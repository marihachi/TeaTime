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
			// ログアウト
			$(function() {
				$('#logout-button').click(function() {
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/account/logout", {
						type: 'post',
						dataType: 'json',
					}).done(function() {
						location.href = "http://marihachi.php.xdomain.jp/tea-time/";
					}).fail(function() {
						$('#logout-message').text('ログアウトに失敗しました');
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
			body {
				background: #eee;
				color: #333;
				padding-top: 94px;
			}
			.btn-teatime-1 {
				background: transparent;
				border: 1px solid #fff;
				color: #fff;
			}
			.btn-teatime-1:hover,
			.btn-teatime-1:active,
			.btn-teatime-1:focus{
				color: #eee;
			}
			
			.home-nav {
				position: fixed;
				top: 0px;
				right: 0px;
				left: 0px;
				z-index: 1030;
				padding: 6px;
				
				color: #fff;
				background: #D59B6D;
				opacity: 0.92;
			}
			.home-nav a {
				font-size: 16px;
			}
			.form-control {
				color: #555;
				background-color: rgba(255, 255, 255, 0.6);
				box-shadow: none;
			}
			.form-control:focus {
				border-color: #FF9A00;
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 4px rgba(251, 152, 0, 0.6);
			}
		</style>
	</head>
	<body>
		<nav class="home-nav">
			<div class=container>
				<div class=row>
					<div class="col-xs-4 row">
						<div class="col-xs-6"><a href="#">Home</a></div>
						<div class="col-xs-6"><a href="#">Mention</a></div>
					</div>
					<div class="col-xs-6">
						<div class=input-group>
							<input type=text class="form-control" id=post-text-box>
							<span class="input-group-btn">
								<button class="btn btn-teatime-1" id=post-button>Post</button>
							</span>
						</div>
					</div>
					<div class="col-xs-2">
						<button id=logout-button class="btn btn-default">ログアウト</button>
					</div>
				</div>
			</div>
		</nav>
		<main>
			
		</main>
	</body>
</html>