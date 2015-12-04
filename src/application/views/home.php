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
			var timelineTimerHandler = null;
			var statusBuilder = {
				analyze: function(statusObject) {
					var li = $('<li>');
					var entry = $('<article class="entry">');
					var userIcon = $('<img class="user-icon" src="icon_test.jpg">');
					var div = $('<div>');
					var header = $('<header>');
					var user_name = $('<span class="user-name">');
					var a = $('<a>');
					var user_screen_name = $('<span class="user-screen-name">');
					var p = $('<p>');
					var time = $('<time>');
					li.append(
						entry.append(
							userIcon
						).append(
							div.append(
								header.append(
									a.attr(
										{ href: statusObject.user.screen_name }
									).append(
										user_name.append(statusObject.user.name)
									).append(
										user_screen_name.append(statusObject.user.screen_name)
									)
								).append(
									time.append(statusObject.created_at)
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
						$('#user-timeline').prepend(statusBuilder.analyze(e));
					});
				},
			};
			$(function() {
				// status-timeline
				var sinceId = 0;
				function updateTimeline() {
					$.ajax("api/web/status/timeline", {
						type: 'get',
						dataType: 'json',
						timeout: 5000,
						data: {'since_id': sinceId}
					}).done(function(res) {
						if (res.statuses.length !== 0)
						{
							sinceId = res.statuses[0].id;
							res.statuses.reverse();
							statusBuilder.build(res.statuses);
						}
					}).fail(function(res) {
						if (timelineTimerHandler !== null)
							clearInterval(timelineTimerHandler);
						alert("タイムライン情報の取得に失敗しました。再読み込みしてください。");
					});
				};
				updateTimeline();
				timelineTimerHandler = setInterval(function() {
					updateTimeline();
				}, 5000);
				// account-logout
				$('#logout-button').click(function(event) {
					event.preventDefault();
					$.ajax("api/web/account/logout", {
						type: 'get',
						dataType: 'json',
						timeout: 10000
					}).done(function() {
						location.href = "<?=$this->config->base_url();?>";
					}).fail(function() {
						alert('ログアウトに失敗しました');
					});
				});
				// status-update
				$('.home-postbar > form').submit(function(event) {
					event.preventDefault();
					$.ajax("api/web/status/update", {
						type: 'post',
						dataType: 'json',
						timeout: 10000,
						data: {"text": $('.home-postbar > form > textarea').val()}
					}).done(function(res) {
						MainTimelineTimer = null;
						sinceId = res.status.id;
						statusBuilder.build([res.status]);
						updateTimeline();
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
			.entry > div > header .user-name {
				font-size: 18px;
			}
			.entry > div > header .user-screen-name {
				font-size: 16px;
				color: rgba(5, 5, 5, 0.5);
			}
			.entry > div > header time {
				margin-left: 10px;
			}
			.entry > div > header .user-screen-name:before {
				content: "@";
				margin-left: 5px;
			}
			.entry > div > p {
				
			}
			#info-timeline .entry {
				border: 1px solid rgb(183, 123, 0);
			}
		</style>
	</head>
	<body>
		<aside class="home-sidebar">
			<ul>
				<li><a href="<?=$this->config->base_url();?>" title="ホームを表示します。">Home</a></li>
				<li><a href="<?=$this->config->base_url();?>i/mentions" title="ごめんなさい。まだ未実装です。">Mention</a></li>
				<li><a href="" id="logout-button" title="TeaTimeからサインアウトします。">Signout</a></li>
			</ul>
		</aside>
		<main>
			<ol class="timeline" id="info-timeline">
				<li>
					<article class="entry">
						<img class="user-icon" src="icon_test.jpg">
						<div>
							<header>
								<span class="user-name">お知らせ</span>
							</header>
							<p>Homeは現在テスト中です！投稿して遊んでね！<br />作者アカウント: <a href="<?=$this->config->base_url();?>mrhc">@mrhc</a></p>
						</div>
					</article>
				</li>
			</ol>
			<ol class="timeline" id="user-timeline">
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