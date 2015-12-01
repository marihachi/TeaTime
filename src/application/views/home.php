<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>TeaTime</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script>
			var statusBuilder = {
				analyze: function(statusObject) {
					var li = $('<li>');
					var entry = $('<article class="entry">');
					var userIcon = $('<img class="user-icon" src="/tea-time/icon_test.jpg">');
					var div = $('<div>');
					var header = $('<header>');
					var h1 = $('<h1>');
					var a_sn = $('<a>');
					var h2 = $('<h2>');
					var p = $('<p>');
					li.append(
						entry.append(
							userIcon
						).append(
							div.append(
								header.append(
									a_sn.attr(
										{ href: statusObject.user.screen_name }
									).append(
										h1.append(statusObject.user.name)
									).append(
										h2.append(statusObject.user.screen_name)
									)
								)
							).append(
								p.append(statusObject.text)
							)
						)
					);
					return li;
				},
				build: function(statusObjects) {
					statusObjects.forEach(function(e, i, a) {
						$('ol.timeline').prepend(statusBuilder.analyze(e));
					});
				},
			};
			$(function() {
				// status-timeline
				var sinceId = 0;
				(function updateTimeline() {
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/status/timeline", {
						type: 'get',
						dataType: 'json',
						data: {'since_id': sinceId}
					}).done(function(res) {
						sinceId = res.statuses[0].id;
						res.statuses.reverse();
						statusBuilder.build(res.statuses);
					});
					setTimeout(function() {
						updateTimeline();
					}, 10000);
				})();
				// account-logout
				$('#logout-button').click(function(event) {
					event.preventDefault();
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/account/logout", {
						type: 'get',
						dataType: 'json'
					}).done(function() {
						location.href = "http://marihachi.php.xdomain.jp/tea-time/";
					}).fail(function() {
						alert('ログアウトに失敗しました');
					});
				});
				// status-update
				$('.home-postbar > form').submit(function(event) {
					event.preventDefault();
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/status/update", {
						type: 'post',
						dataType: 'json',
						data: {"text": $('.home-postbar > form > textarea').val()}
					}).done(function(res) {
						cursorId = res.status.id;
						statusBuilder.build([res.status]);
						$('.home-postbar > form > textarea').val("");
					}).fail(function() {
						alert('投稿に失敗しました');
					});
				});
			});
		</script>
		<style>
			* {
				box-sizing: border-box;
				color: rgba(5, 5, 5, 0.7);
				margin: 0;
				padding: 0;
				word-wrap: break-word;
			}
			a , a:active, a:focus {
				color: rgba(5, 5, 5, 0.7);
				text-decoration: none;
			}
			a:hover {
				color: rgba(5, 5, 5, 0.9);
			}
			body {
				background-color: rgba(235, 217, 207, 1);
			}
			body > div {
				top: 0 !important;
				left: auto !important;
				right: 0 !important;
			}
			main {
				display: block;
				padding-left: 160px;
				padding-bottom: 100px;
			}
			.home-sidebar {
				background-color: rgb(209, 170, 147);
				width: 160px;
				height: 100%;
				padding: 20px 0;
				position: fixed;
				top: 0;
				left: 0;
			}
			.home-sidebar a ,
			.home-sidebar a:active,
			.home-sidebar a:focus {
				color: rgba(250,250,250, 0.7);
				text-decoration: none;
			}
			.home-sidebar a:hover {
				color: rgba(250,250,250, 0.9);
			}
			.home-sidebar > ul > li {
				list-style: none;
			}
			.home-sidebar > ul > li > a {
				display: flex;
				align-items: center;
				justify-content: flex-start;
				padding: 0px 35px;
				height: 50px;
				font-size: 16px;
			}
			.home-sidebar > ul > li > button {
				height: 50px;
				width: 100%;
				border: 1px solid rgba(250, 250, 250, .2);
				background-color: transparent;
				color: rgba(250, 250, 250, .7);
			}
			.home-sidebar > ul > li > button:hover {
				color: rgba(250,250,250, 0.9);
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
				border: 1px solid rgb(183, 123, 87);
				color: rgb(183, 123, 87);
				background-color: transparent;
				width: 60px;
			}
			.timeline > li {
				list-style: none;
			}
			.entry {
				display: flex;
				background-color: rgba(250, 250, 250, .2);
				margin: 10px;
				padding: 10px 0px;
				border-radius: 5px;
			}
			.entry > .user-icon {
				height: 64px;
				width: 64px;
				margin: 0px 15px;
				border: 2px solid rgb(250, 250, 250);
				border-radius: 5px;
			}
			.entry > div > header > a {
				display: flex;
				align-items: baseline;
			}
			.entry > div > header h1 {
				font-size: 18px;
				font-weight: 400;
			}
			.entry > div > header h2 {
				font-size: 16px;
				font-weight: 400;
				color: rgba(5, 5, 5, 0.5);
			}
			.entry > div > header h2:before {
				content: "@";
				margin-left: 5px;
			}
			.entry > div > p {
				
			}
		</style>
	</head>
	<body>
		<aside class="home-sidebar">
			<ul>
				<li><a href="">Home</a></li>
				<li><a href="i/mentions">Mention</a></li>
				<li><a href="" id="logout-button">ログアウト</a></li>
			</ul>
		</aside>
		<main>
			<ol class="timeline">
				<!--<li>
					<article class="entry">
						<img class="user-icon" src="/tea-time/icon_test.jpg">
						<div>
							<header>
								<h1>お知らせ</h1>
								<h2>Information</h2>
							</header>
							<p>Homeは現在テスト中です！投稿して遊んでね！</p>
						</div>
					</article>
				</li>-->
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