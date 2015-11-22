<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<meta http-equiv=X-UA-Compatible content="IE=edge" />
		<meta name=viewport content="width=device-width, initial-scale=1" />
		<title><?php echo $user["name"];?>さんのページ - TeaTime | ティータイムにピッタリなSNS</title>
		<script src=//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js></script>
		<script>
			$(function() {
				$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/friend/show", {
						type: 'get',
						dataType: 'json',
						data: {"screen_name": '<?php echo $user["screen_name"];?>'}
					}).done(function(data) {
						if (data.is_following) {
							$('#follow-button > button')
								.attr('id','follow-button-on')
								.text('フォロー中');
						} else {
							$('#follow-button > button')
								.attr('id','follow-button-off')
								.text('フォロー');
						}
					}).fail(function(data) {
						alert('フォローに失敗しました (' + data.responseJSON.error.message + ')');
					});
				// follow
				$('#follow-button-off').click(function() {
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/user/follow", {
						type: 'post',
						dataType: 'json',
						data: {"screen_name": '<?php echo $user["screen_name"];?>'}
					}).done(function() {
						$('#follow-button > div')
							.attr('id','follow-button-on')
							.text('フォロー中');
					}).fail(function(data) {
						alert('フォローに失敗しました (' + data.responseJSON.error.message + ')');
					});
				});
				// unfollow
				$('#follow-button-on').click(function() {
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/user/unfollow", {
						type: 'post',
						dataType: 'json',
						data: {"screen_name": '<?php echo $user["screen_name"];?>'}
					}).done(function() {
						$('#follow-button > div')
							.attr('id','follow-button-off')
							.text('フォロー');
					}).fail(function() {
						alert('アンフォローに失敗しました');
					});
				});
			});
		</script>
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
	</head>
	<body>
		<main>
			<img src="/teatime/image/icon/<?php echo $user["screen_name"];?>">
			<p><?php echo $user["name"]."(@".$user["screen_name"].")";?></p>
			<div id="follow-button">
				<button class="btn btn-defalut" id="follow-button-off">フォロー</button>
			</div>
			<p>bio: <?php echo $user["bio"];?></p>
			<p>Lv: <?php echo $user["lv"];?></p>
			<p>Exp: <?php echo $user["exp"];?></p>
			<p><a href=/tea-time>ホームへ</a></p>
		</main>
	</body>
</html>